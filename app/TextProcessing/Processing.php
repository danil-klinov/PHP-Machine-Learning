<?php

namespace TextProcessing;

//define('N', 2);
//define('THEME', 2);
define('TOP', 10);

use TextProcessing\LinguaStemRu;

class Processing 
{
	
	function getKeyWords(){
		$keyWordsFile = __DIR__ . '/keyWords.txt';
		$keyWords = array();
		if (file_exists($keyWordsFile)) {
			$file = file_get_contents($keyWordsFile);
			$textik  = mb_detect_encoding($file, array('utf-8', 'cp1251'));
			$file = iconv($textik, 'UTF-8', $file);
			$file = str_replace("\n", " ", $file);
			$keyWords = explode(" ", $file);
		} 
		else{
			$textTheme = array();
			$wordsTheme = array();
			$allWords = array();
			for ($theme = 0; $theme < THEME; $theme++){
				$wordsTheme[$theme] = array();
				$textTheme[$theme] = array();
				for ($q = 0; $q < N; $q++){
					$file = file_get_contents(__DIR__ . '/../DataSet/Text/' . $theme . '/' . $q . '.txt');
					$text = $this->getAllWords($file);
					$text = $this->deleteStopWords($text);
					$text = $this->doStemmWithText($text);
					$textTheme[$theme][] = $text;
					foreach($text as $key => $value){
						$wordsTheme[$theme][] = $value;
						$allWords[] = $value;
					}
				}
			}
			
			$x = count($allWords);
			$new_grand_array= array_unique($allWords);
			$allUniqueWords  = array();
			foreach ($new_grand_array as $key => $value){
				if( $value != '' && $value != '	' && $value != ' '  && $value != '\r' && $value != "\n" && $value != null && $value != false){
					array_push($allUniqueWords, $value);
				}
			}
			
			
			
			$tfIdf = array();
			foreach ($allUniqueWords as $key => $value){
				$documentsHaveWord = array();
				$countWord = array();

				for ($theme = 0; $theme < THEME; $theme++){
					$documentsHaveWord[$theme] = 0;
					$countWord[$theme] = 0;
					for ($q = 0; $q < N; $q++){
						if (in_array($value, $textTheme[$theme][$q]))
							$documentsHaveWord[$theme]++;
						for ($k = 0; $k < count($textTheme[$theme][$q]); $k++){
							if ($value == $textTheme[$theme][$q][$k])
								$countWord[$theme]++;
						}
					}
				}
				
				for ($theme = 0; $theme < THEME; $theme++){
					$tf = $countWord[$theme]/(float)count($wordsTheme[$theme]);					
					$sum = 0;
					for ($theme2 = 0; $theme2 < THEME; $theme2++){
						if ($theme != $theme2)
							$sum += $documentsHaveWord[$theme2];
					}
					if ($sum != 0) $idf = log(THEME*N/(float)$sum);
					else $idf = 0;
					
					$tfIdf[$theme][$value]= $tf*$idf;
				}
				
			}
			
			for ($theme = 0; $theme < THEME; $theme++){
				arsort($tfIdf[$theme]);
				$top = array_slice($tfIdf[$theme],0,TOP);
				foreach ($top as $key => $value){
					//echo $key . " " . $value . " \n";
					if(!in_array($key,$keyWords))$keyWords[] = $key;
				} 				
			}
			
			$fp = fopen($keyWordsFile, 'a');
			foreach ($keyWords as $key => $value){
				fwrite($fp, mb_strtolower($value) . PHP_EOL);	
			}
			fclose($fp);
		}
		
		return $keyWords;
	}
	
	
	
	function getCountWordsFromVector($arr) {
		$vector = array();
		foreach (array_count_values($arr) as $key => $value) {
			$vector[$key] = $value;
		}
		return $vector;
	}
	
	function getAllWords($file){
		$textik  = mb_detect_encoding($file, array('utf-8', 'cp1251'));
		$file = iconv($textik, 'UTF-8', $file);
		$file = str_replace("\n", " ", $file);
		$text = explode(" ", $file);
		for ($i = 0; $i < count($text); $i++){
		$text[$i] = str_replace("'", "", $text[$i]);
		$text[$i] = str_replace(":", "", $text[$i]);
		$text[$i] = str_replace(";", "", $text[$i]);
		$text[$i] = str_replace("`", "", $text[$i]);
		$text[$i] = str_replace("~", "", $text[$i]);
		$text[$i] = str_replace("!", "", $text[$i]);
		$text[$i] = str_replace("@", "", $text[$i]);
		$text[$i] = str_replace("#", "", $text[$i]);
		$text[$i] = str_replace("�", "", $text[$i]);
		$text[$i] = str_replace("$", "", $text[$i]);
		$text[$i] = str_replace("%", "", $text[$i]);
		$text[$i] = str_replace("^", "", $text[$i]);
		$text[$i] = str_replace("&", "", $text[$i]);
		$text[$i] = str_replace("?", "", $text[$i]);
		$text[$i] = str_replace("*", "", $text[$i]);
		$text[$i] = str_replace("(", "", $text[$i]);
		$text[$i] = str_replace(")", "", $text[$i]);
		$text[$i] = str_replace("-", "", $text[$i]);
		$text[$i] = str_replace("_", "", $text[$i]);
		$text[$i] = str_replace("+", "", $text[$i]);
		$text[$i] = str_replace("=", "", $text[$i]);
		$text[$i] = str_replace("{", "", $text[$i]);
		$text[$i] = str_replace("}", "", $text[$i]);
		$text[$i] = str_replace("[", "", $text[$i]);
		$text[$i] = str_replace("]", "", $text[$i]);
		$text[$i] = str_replace(".", "", $text[$i]);
		$text[$i] = str_replace(",", "", $text[$i]);
		$text[$i] = str_replace("<", "", $text[$i]);
		$text[$i] = str_replace(">", "", $text[$i]);
		$text[$i] = str_replace("\\", "", $text[$i]);
		$text[$i] = str_replace("/", "", $text[$i]);
		$text[$i] = str_replace("\r", "", $text[$i]);
		$text[$i] = str_replace(" ", "", $text[$i]);
		$text[$i] = str_replace("\"", "", $text[$i]);
		$text[$i] = str_replace("�", "", $text[$i]);
		$text[$i] = str_replace("�", "", $text[$i]);
		$text[$i] = str_replace("�", "", $text[$i]);
		$text[$i] = str_replace("	", "", $text[$i]);
		$text[$i] = str_replace("�", "", $text[$i]);
		$text[$i] = str_replace("�", "", $text[$i]);
		}
		return $text;
	}
	
	function deleteStopWords($text){
		
		$stop_words = file_get_contents(__DIR__ . '/stop_words.txt');
		$stop_words = str_replace("\n", " ", $stop_words);
		$array_stop_words = explode(" ", $stop_words);
		for ($i = 0; $i < count($text); $i++){
			for ($stop = 0; $stop < count($array_stop_words); $stop++){
				if (mb_strtolower($text[$i]) == mb_strtolower($array_stop_words[$stop])){
					$text[$i] = "";
				}
			}
		}
		return $text;
	}
	function doStemmWithText($text){
		$stemmer = new LinguaStemRu();
		for ($i = 0; $i < count($text); $i++){
		$text[$i] = $stemmer->stem_word($text[$i]);
		}
		return $text;
	}
	
	
	
	
	
	
	
	
}