<?php
namespace TextProcessing;

define('THEME', "THEME_");
define('TEXT', "TEXT_");
define('TXT', ".txt");
define('WAY', "C:\\texts\\");

class WorkWithText
{
    
    public static function getTheme($number)
    {
        $theme = file_get_contents(WAY . THEME . $number . TXT);
        return $theme;
    }

    public static function getWords($number){
        $allWords = file_get_contents(WAY . TEXT . $number . TXT);
        $words = explode("\n", $allWords);
        return $words;
    }
    
}

