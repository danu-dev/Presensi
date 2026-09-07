<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Attendance Configurations
    |--------------------------------------------------------------------------
    */
    'open_time' => env('ATTENDANCE_OPEN_TIME', '05:00'),
    'manual_check_in_time' => env('ATTENDANCE_MANUAL_CHECK_IN', '08:00:00'),
    'manual_check_out_time' => env('ATTENDANCE_MANUAL_CHECK_OUT', '16:00:00'),
    'earth_radius' => 6371000, // in meters
];
