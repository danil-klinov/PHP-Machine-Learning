<?php

define('N', 4);

require_once 'steming/LinguaStemRu.php';

//include "index.html";
//echo "START";

$stop_words = file_get_contents("stop_words.txt");
$stop_words = str_replace("\n", " ", $stop_words);
$array_stop_words = explode(" ", $stop_words);

$stemmer = new Stem\LinguaStemRu();

for ($q = 0; $q < N; $q++){
	
	$file = file_get_contents($q . ".txt");
	$textik  = mb_detect_encoding($file, array('utf-8', 'cp1251'));
	$file = iconv($textik, 'UTF-8', $file);
	$file = str_replace("\n", " ", $file);
	$text[$q] = explode(" ", $file);
	
	for ($i = 0; $i < count($text[$q]); $i++){
		$text[$q][$i] = str_replace("'", "", $text[$q][$i]);
		$text[$q][$i] = str_replace(":", "", $text[$q][$i]);
		$text[$q][$i] = str_replace(";", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("`", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("~", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("!", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("@", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("#", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("№", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("$", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("%", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("^", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("&", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("?", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("*", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("(", "", $text[$q][$i]);
		$text[$q][$i] = str_replace(")", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("-", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("_", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("+", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("=", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("{", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("}", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("[", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("]", "", $text[$q][$i]);
		$text[$q][$i] = str_replace(".", "", $text[$q][$i]);
		$text[$q][$i] = str_replace(",", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("<", "", $text[$q][$i]);
		$text[$q][$i] = str_replace(">", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("\\", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("/", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("\r", "", $text[$q][$i]);
		$text[$q][$i] = str_replace(" ", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("\"", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("—", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("»", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("«", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("	", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("“", "", $text[$q][$i]);
		$text[$q][$i] = str_replace("”", "", $text[$q][$i]);
		//echo $text[$q][$i] . PHP_EOL;
	}
	
	for ($i = 0; $i < count($text[$q]); $i++){
		for ($stop = 0; $stop < count($array_stop_words); $stop++){
			if (mb_strtolower($text[$q][$i]) == mb_strtolower($array_stop_words[$stop])){
				$text[$q][$i] = "";
			}
		}
	}
	
	for ($i = 0; $i < count($text[$q]); $i++){
		$text[$q][$i] = $stemmer->stem_word($text[$q][$i]);
	}

	//$new_text[$q] = array_diff($text[$q], array('', null, false, "\n", "\r", " ", "	")); 
	//$text[$q] = $new_text[$q];
	
	//$file = $q . $q . $q . '.txt';
	//$fp = fopen($file, 'a');
	//for ($i = 0; $i < count($text[$q]); $i++){
	//	fwrite($fp, mb_strtolower($text[$q][$i]) . PHP_EOL);	
	//}
	//fclose($file);

}

$grand_array = array();

for ($q = 0; $q < N; $q++){
	$grand_array = array_merge($grand_array, $text[$q]);
}

$new_grand_array = array();

$new_grand_array = array_unique($grand_array);

$final = array();

$x = count($new_grand_array);

for ($i = 0; $i < $x; $i++){
	if($new_grand_array[$i] != '' || $new_grand_array[$i] != '	' || $new_grand_array[$i] != ' '  || $new_grand_array[$i] != '\r' || $new_grand_array[$i] != "\n" || $new_grand_array[$i] != null || $new_grand_array[$i] != false){
		if (array_key_exists($i, $new_grand_array))
			array_push($final, $new_grand_array[$i]);
		else 
			$x++;
	}
}

//$grand_array = asort($new_grand_array);

//print_r($new_grand_array);
//print_r($grand_array);

$in_texts = array();
$inside = array();
$max = 0;

for ($i = 0; $i < count($final); $i++){
	$in_text[$i] = 0;
	for ($q = 0; $q < N; $q++){
		if (in_array($final[$i], $text[$q]))
			$in_text[$i]++;
		$inside[$i][$q] = 0;
		for ($k = 0; $k < count($text[$q]); $k++){
			if ($final[$i] == $text[$q][$k])
				$inside[$i][$q]++;
				if ($inside[$i][$q] > $max)
					$max = $inside[$i][$q]
		}
	}
	//echo $in_text[$i] . " " . $inside[$i][0] . " " . $inside[$i][1] . "\n";
	//echo PHP_EOL;
}

/*$file = 'grand.txt';
	$fp = fopen($file, 'a');
	for ($i = 0; $i < count($final); $i++){
		fwrite($fp, mb_strtolower($final[$i]) . PHP_EOL);	
	}
	fclose($file);*/

/*for ($q = 0; $q < 4; $q++){
	
	$file = file_get_contents($q . $q . $q . ".txt");
	$file = str_replace("\n", " ", $file);
	$text[$q] = explode(" ", $file);
	
	for ($i = 0; $i < count($text[$q]); $i++){
		$text[$q][$i] = str_replace(" ", "", $text[$q][$i]);
	}
	
}*/

?>


