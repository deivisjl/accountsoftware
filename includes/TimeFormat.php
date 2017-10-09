<?php
class TimeFormat{
 
    static function imprimirTiempo($get_timestamp)
{
        $timestamp = strtotime($get_timestamp);
        $diff = time() - (int)$timestamp;

        if ($diff == 0) 
             return 'justo ahora';

        if ($diff > 604800)
            return date("d M Y",$timestamp);

        $intervals = array
        (
            $diff < 604800      => array('día',     86400),
            $diff < 86400       => array('hora',    3600),
            $diff < 3600        => array('minuto',  60),
            $diff < 60          => array('segundo',  1)
        );

        $value = floor($diff/$intervals[1][1]);
        return 'hace '.$value.' '.$intervals[1][0].($value > 1 ? 's' : '');
}
}
?>