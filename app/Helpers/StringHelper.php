<?php

namespace App\Helpers;

class StringHelper
{
    public static function detectPhoneNumber(string $string)
    {
        return str_replace(['(', ')', ' ', '+', '-', '#'], '', $string);
    }
}
