<?php

class Page {

    static $data = array();

    static function Build($start = 1) {

        $start = (is_numeric($start) && $start > 0) ? $start : 1;
        self::$data['start'] = $start;

        $category = (isset($_GET['category']) && is_numeric($_GET['category'])) ? $_GET['category'] : FALSE;
        self::$data['category'] = $category;

        Load::view('ucp', self::$data);
    }

    static function points($limit, $where = null) {
        DB::query("SELECT Full_name, points, username, email, adress, activities FROM users $where ORDER BY points DESC LIMIT $limit");
        self::$data['count'] = DB::num_rows();

        if (DB::num_rows() > 0) {
            $return = DB::fetch_array();



            return $return;
        }

        return array();
    }

    static function joinbooking() {
        DB::query("SELECT booking.id, booking.employee_id, booking.title, booking.start, booking.ends, users.username, users.Full_name FROM booking INNER JOIN users ON booking.employee_id = users.id");
        self::$data['count'] = DB::num_rows();
        $calender = array();
        if (DB::num_rows() > 0) {

            $events = DB::fetch_array();
            
            foreach ($events as $event) {
                $start = explode("T", $event['start']);
                $startDate = explode("-", $start[0]);
                $end = explode("T", $event['ends']);
                $endDate = explode("-", $end[0]);
                    $d = gregoriantojd($startDate[1], $startDate[2], $startDate[0]);
                    $m = jdmonthname($d, 1);
                    if (array_key_exists($startDate[0], $calender)){
                        if(in_array($m, $calender[$startDate[0]])){
                            
                        }else{
                            array_push($calender[$startDate[0]], $m);
                        }
                    }else{
                        $calender[$startDate[0]] = array();
                        if(in_array($m, $calender[$startDate[0]])){
                            
                        }else{
                            array_push($calender[$startDate[0]], $m);
                        }
                    }
            }
            $return = array();
            foreach($calender as $key => $value){
                if(!key_exists($key, $return)){
                    $return[$key] = array();
                }
               
                foreach($value as $months){
                    $i = date_parse($months);
                    $return[$key][$months] = array();
//                    $return[$key][$i['month']] = $months;
                    
                }
            }
            foreach ($events as $event) {
                $start = explode("T", $event['start']);
                $startDate = explode("-", $start[0]);
                $end = explode("T", $event['ends']);
                $endDate = explode("-", $end[0]);
                    $d = gregoriantojd($startDate[1], $startDate[2], $startDate[0]);
                    $m = jdmonthname($d, 1);
                        if(array_key_exists($startDate[0], $return)){
                            if(array_key_exists($m, $return[$startDate[0]])){
                                if(array_key_exists($startDate[2], $return[$startDate[0]][$m])){
                                    array_push($return[$startDate[0]][$m][$startDate[2]], $event);
//                                    $startDate[2], $return[$startDate[0]][$m]
                                }else{
                                    $return[$startDate[0]][$m][$startDate[2]] = array();
                                    array_push($return[$startDate[0]][$m][$startDate[2]], $event);
                                }
                                
                            }
                        }
            }
            return $return;
        }

    }

    static function paginate() {
        $p = '';
        $start = self::$data['start'];
        $news = self::$data['count'];
        $max = Config::item('sites_per_page');
        $category = self::$data['category'];

        if ($start > $max + 1 || (($start > $max) == FALSE && $start != 1)) {
            $p .= '<a href=\'?index=1&category=' . $category . '\'><</a> ';
        }

        if ($start > $max) {
            $page = $start - $max;
            $p .= '<a href=\'?index=' . $page . '&category=' . $category . '\'>' . $page . '</a> ';
        }

        $page = $start + $max;
        $p .= $start . ' ';

        if ($max <= $news - 1) {
            $p .= '<a href=\'?index=' . $page . '&category=' . $category . '\'>' . $page . '</a> ';
        }

        if ((($start + $max < $news) == FALSE && ($start + $max < $news - $max + 1)) || ($page < $news - $max + 1)) {
            $page = $news - $max + 1;
            $p .= '<a href=\'?index=' . $page . '&category=' . $category . '\'>></a>';
        }

        if ($p != $start . ' ') {
            echo $p;
        }
    }

}