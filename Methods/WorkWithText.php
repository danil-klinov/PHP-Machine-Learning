<?php

define('LANGUAGE', "LANGUAGE_");
define('TEXT', "TEXT_");
define('TXT', ".txt");
define('WAY', "C:\\texts\\");

class WorkWithText
{
    
    public static function getLanguage($number)
    {
        $language = file_get_contents(WAY . LANGUAGE . $number . TXT);
        return $language;
    }

    public static function getWords($number){
        $allWords = file_get_contents(WAY . TEXT . $number . TXT);
        $words = explode("\n", $allWords);
        return $words;
    }

    public function buildTextVector($array)
    {
        $vector = array();

        foreach (array_count_values($array) as $key => $value) {
            $vector[$key] = $value;
        }

        return $vector;
    }
    
}

