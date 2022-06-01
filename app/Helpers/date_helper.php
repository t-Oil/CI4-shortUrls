<?php
if (!function_exists("dateTh")) {
    function dateTh(string $string)
    {
        $thai_months = [
            1 => 'ม.ค.',
            2 => 'ก.พ.',
            3 => 'มี.ค.',
            4 => 'เม.ย.',
            5 => 'พ.ค.',
            6 => 'มิ.ย.',
            7 => 'ก.ค.',
            8 => 'ส.ค.',
            9 => 'ก.ย.',
            10 => 'ต.ค.',
            11 => 'พ.ย.',
            12 => 'ธ.ค.',
        ];

        $date = date('Y-m-d H:i:s', strtotime($string));
        $y = date("Y", $date) +543;
        return $y;
        // $month = $thai_months[$date->month];
        // $year = $date->year + 543;
        // return $date->format("j $month $year H:i:s");
    }
}