<?php
// This file contains only one function, which is randomString. This function is inherited from 
// previous version. The reason we put the function in a separate folder/file is we want to 
// organize our codes in the OOP style.
namespace app\helpers;

class UtilHelper{
    public static function randomString($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = '';
        for ($i = 0; $i < $n; $i++){
            $index = rand(0, strlen($characters) - 1);
            $str .= $characters[$index];
        }
        return $str;
    }
}