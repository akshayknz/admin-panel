<?php

if (! function_exists('get_percentage_change')) {
    function get_percentage_change($current, $past)
    {
        $increase = $current - $past;
        if($current == 0 && $past == 0){
            $percent = 0;
        } elseif($past == 0){
            $percent = 100;
        } else{
            $percent = ($increase/$past)*100;
        }
        
        return number_format( (float)$percent, 2, '.', '' ) + 0;
    }
}

// "files": [
//     "app/helpers.php"
// ],