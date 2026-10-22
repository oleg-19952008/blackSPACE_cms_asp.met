<?php

class Subpage {

    static $data = array(
        'message' => 'You can manage your users here.',
        'navigation' => array(),
        'events' => array(),
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

        Load::view('points', self::$data, TRUE);
    }

    static function message($message, $color = 'red') {
        self::$data['message'] = '<b style=\'color:' . $color . ';\'>' . $message . '</b>';
    }

}