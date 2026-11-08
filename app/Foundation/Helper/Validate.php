<?php

namespace App\Foundation\Helper;

use Carbon\Carbon;

class Validate
{
    public static function month_year(string|int $month = NULL, string|int $year = NULL) : bool
    {
        if($month){
            if(!(ctype_digit($month) && (int)$month >= 1 && (int)$month <= 12))
                return FALSE;
        }
        if($year){
            if(!(ctype_digit($year) && strlen($year) === 4))
                return FALSE;
        }
        return TRUE;
    }
}
