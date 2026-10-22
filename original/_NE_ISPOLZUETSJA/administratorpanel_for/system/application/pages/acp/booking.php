<?php

class Subpage {

    static $data = array(
        'message' => 'You can manage your users here.',
        'navigation' => array(),
        'events' => array(),
        'types' => array(),
        'edit' => array(),
        'instructors' => null);

    static function Build() {
        //Check for Admin
        if (User::$isAdmin == FALSE) {
            redirect();
        }

        //Get the navigation
        DB::query("SELECT * FROM navigation ORDER BY id ASC");

        if (DB::num_rows() > 0) {
            self::$data['navigation'] = DB::fetch_array();
        }
        DB::query("SELECT id, Full_name FROM users WHERE isEmployee = 1 ORDER BY id ASC");
        if (DB::num_rows() > 0) {
            $return = DB::fetch_array();
            self::$data['instructors'] = $return;
        }

        DB::query("SELECT booking.id, booking.employee_id, booking.title, booking.start, booking.ends, users.Full_name FROM booking INNER JOIN users ON booking.employee_id = users.id");
        if (DB::num_rows() > 0) {
            $return = DB::fetch_array();
            self::$data['events'] = $return;
        }
         DB::query("SELECT * FROM categories");
        if (DB::num_rows() > 0) {
            $return = DB::fetch_array();
            self::$data['types'] = $return;
        }
         if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = $_GET['id'];
            DB::query("SELECT booking.id, booking.employee_id, booking.title, booking.start, booking.ends, users.Full_name FROM booking INNER JOIN users ON booking.employee_id = users.id WHERE booking.id='$id' ");
            if (DB::num_rows() > 0) {
                self::$data['edit'] = DB::fetch_array();
            }
        }

        Load::view('booking', self::$data, TRUE);
    }

    static function bookSession($array) {
        $who = $array['who'];
        $start = $array['start'];
        $ends = $array['ending'];
        $title = $array['title'];
        DB::query("INSERT INTO booking SET employee_id = '$who', title = '$title', start = '$start', ends='$ends'");
        return true;
    }
    static function editBooking($array) {
        $who = $array['who'];
        $start = $array['start'];
        $ends = $array['ending'];
        $title = $array['title'];
        $id = $array['id'];
        DB::query("UPDATE booking SET employee_id = '$who', start = '$start', ends = '$ends', title = '$title' WHERE '$id' = id") or die(mysqli_error());
        return true;
    }
    
     static function DeleteBooking($id) {
	DB::query("DELETE FROM booking WHERE id = '$id' LIMIT 1");
        return true;
    }
    static function message($message, $color = 'red') {
        self::$data['message'] = '<b style=\'color:' . $color . ';\'>' . $message . '</b>';
    }

}