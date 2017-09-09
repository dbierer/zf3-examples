<?php
namespace PrivateMessages\Generic;

class MakePrime
{
    const DEFAULT_MIN = 1000000000;
    const DEFAULT_RANGE = 1000;
    public static function getPrimes($min = self::DEFAULT_MIN, $range = self::DEFAULT_RANGE)
    {
        $max = $min + $range;
        $test = TRUE;
        for ($x = $min; $x < $max; $x++)
        {
            // checks to see if number is odd or even
            if($x % 2 !== 0) {
                for($i = $min; $i < $x; $i++) {
                    if(($x % $i) === 0) {
                        $test = FALSE;
                        break 2;
                    }
                }
            }
        }
        return ($test) ? $x : 1;
    }
}
