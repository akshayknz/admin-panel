<?php

if (! function_exists('get_percentage_change')) {
    function get_percentage_change($a, $b)
    {
        $increase = $a - $b;
        if($a == 0 && $b == 0){
            $percent = 0;
        } elseif($b == 0){
            $percent = 100;
        }else{
            $percent = ($increase/$b)*100;
        }
        
        return number_format( (float)$percent, 2, '.', '' ) + 0;
    }
}
