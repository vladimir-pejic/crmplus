<?php

namespace App;


class Helpers {

    public static function random($len = 8) {

        if($len < 8)
            $len = 8;

        $sets = array();
        $sets[] = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        $sets[] = '23456789';
        //$sets[]  = '~!@#$%^&*(){}[],./?';

        $random = '';

        foreach ($sets as $set) {
            $random .= $set[array_rand(str_split($set))];
        }

        while(strlen($random) < $len) {
            $randomSet = $sets[array_rand($sets)];
            $random .= $randomSet[array_rand(str_split($randomSet))];
        }

        return str_shuffle($random);
    }

}