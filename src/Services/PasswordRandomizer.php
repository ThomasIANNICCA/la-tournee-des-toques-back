<?php

namespace App\Services;

class PasswordRandomizer 
{
    /**
     * return a password with the expected format : at least one letter, one uppercase letter, one number, one special character and 12 characters in total.
     *
     * @return string
     */
    public function createPassword(): string
    {
        $string = "abcdefghijklmnopqrstuvwxyz";

        $stringUpperCase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        
        $newString = substr(str_shuffle($string),0, 5) . rand(1,9) . substr(str_shuffle($stringUpperCase), 0, 5) . '!';
        
        return str_shuffle($newString);
    }
}