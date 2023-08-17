<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use PhpOffice\PhpSpreadsheet\Calculation\Web;
use Illuminate\Support\Facades\DB;

class CommonHelper
{
    public  static function snakeToWords(String $input)
    {
        $snake = explode("_", $input);
        return ucwords(implode(' ', $snake));
    }
    public  static function slugToWords(String $input)
    {
        $snake = explode("-", $input);
        return ucwords(implode(' ', $snake));
    }

    public  static function currency($input, bool $useRp = false, bool $alignRp = false){
        $suffix = $useRp ? "Rp. " : "";
        if ($alignRp) {
            return $suffix.'<span class="float-right">'.number_format($input, 0, ",", ".").'</span> ';
        }
        return $suffix. number_format($input, 0, ",", ".");
    }

    public static function getPronounceThousands($num)
    {
        $suffix = "";
        if ($num>1000000000) {
            $num = $num/1000000000;
            $suffix = " T";
        }elseif ($num>1000000) {
            $num = $num/1000000;
            $suffix = " M";
        } elseif($num > 1000) {
            $num = $num/1000;
            $suffix = " K";
        }
        $str = number_format($num, 2, ",", ".");
        return $str.$suffix;
    }
    public static function getDp()
    {
        if (Auth::check() && Auth::user()->name) {
            $name = Auth::user()->name;
            $arr = explode(" ", $name);
            return ucfirst($arr[0][0]);
        } else {
            return "-";
        }
    }

    // function adjustBrightness($hex, $percent, $darken = true) { 
    //     $brightness = $darken ? -255 : 255; 
    //     $steps = $percent * $brightness/100;
    // }

    public static function adjustBrightness($hex, $steps) {
        // Steps should be between -255 and 255. Negative = darker, positive = lighter
        $steps = max(-255, min(255, $steps));
    
        // Normalize into a six character long hex string
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
        }
        
        // Split into three parts: R, G and B
        $color_parts = str_split($hex, 2);
        $return = '#';
    
        foreach ($color_parts as $color) {
            $color = hexdec($color); // Convert to decimal
            $color = max(0, min(255, $color + $steps)); // Adjust color
            $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
        }
        
        return $return;
    }

    public static function convertToTextArrayPg($var)
    {
        $name_list = json_encode($var);
        $name_list = "'".preg_replace("#^\[(.*)\]$#", '{\1}', $name_list)."'";
        return DB::raw($name_list);
    }    

    public static function revertToTextArrayPg($var)
    {
        return preg_replace("#^\{(.*)\}$#", '[\1]', $var);
    }    
}

