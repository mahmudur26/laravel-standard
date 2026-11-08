<?php

namespace App\Foundation\Helper;

use Carbon\Carbon;

class Format
{
    public static function date(?string $date, bool $show_time = FALSE){
        if(!$date)
            return NULL;
        if(!$show_time)
            return Carbon::parse($date)->format('d M, Y');

        return Carbon::parse($date)->format('d M, Y h:i A');
    }


    public static function KB_to_MB(string|int $KB, int $precision = 2)
    {
        return round($KB / 1024, $precision);
    }
}
