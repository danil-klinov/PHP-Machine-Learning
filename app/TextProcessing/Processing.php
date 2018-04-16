<?php

namespace TextProcessing;

define('N', 2);
define('THEME', 6);

use TextProcessing\LinguaStemRu;

class Processing 
{
	
	
	function getKeyWords(){
		
		
		echo "1";
		$keyWordsFile = __DIR__ . '/keyWords.txt';
		$keyWords = array();
		if (file_exists($keyWordsFile)) {
			$file = file_get_contents($keyWordsFile);
			$textik  = mb_detect_encoding($file, array('utf-8', 'cp1251'));
			$file = iconv($textik, 'UTF-8', $file);
			$file = str_replace("\n", " ", $file);
			$text = explode(" ", $file);
			$keyWords = explode(" ", $text);
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
				$wordsTheme[$theme] = array_merge($wordsTheme[$theme], $text);
				}
				$allWords = array_merge($wordsTheme[$theme], $text);
			}
			echo "2";
			$x = count($allWords);
			$new_grand_array= array_unique($allWords);
			
			
			$allUniqueWords  = array();

			foreach ($new_grand_array as $key => $value){
				if( $value != '' && $value != '	' && $value != ' '  && $value != '\r' && $value != "\n" && $value != null && $value != false){
						array_push($allUniqueWords, $value);
				}
			}
			
			
			echo "3";
			$tfIdf = array();
			for ($i = 0; $i < count($allUniqueWords); $i++){
				$documentsHaveWord = array();
				$countWord = array();
				
				for ($theme = 0; $theme < THEME; $theme++){
					$documentsHaveWord[$theme] = 0;
					$countWord[$theme] = 0;
					for ($q = 0; $q < N; $q++){
						if (in_array($allUniqueWords[$i], $textTheme[$theme][$q]))
							$documentsHaveWord[$theme]++;
						for ($k = 0; $k < count($textTheme[$theme][$q]); $k++){
							if ($allUniqueWords[$i] == $textTheme[$theme][$q][$k])
								$countWord[$theme]++;
						}
					}
				}
				
				for ($theme = 0; $theme < THEME; $theme++){
					$tf = $countWord[$theme]/(float)$wordsTheme[$theme];
					
					$sum = 0;
					for ($theme2 = 0; $theme2 < THEME; $theme++){
						if ($theme != $theme2)
							$sum += $documentsHaveWord[$theme2];
					}
					$idf = log(THEME*N/(float)$sum);
					$tfIdf[$theme][$i]= $tf*$idf;
				}
				
			}
			
			for ($theme = 0; $theme < THEME; $theme++){
				sort($tfIdf[$theme]);
				for ($i = 0; $i < 100; $i++){
					$keyWords[] = $tfIdf[$theme][$i];
				}
				
			}
			
			echo "4";
			$fp = fopen($keyWordsFile, 'a');
			for ($i = 0; $i < count($keyWords); $i++){
				fwrite($fp, mb_strtolower($keyWords[$i]) . PHP_EOL);	
			}
			fclose($keyWordsFile);
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
		$text[$i] = str_replace("¹", "", $text[$i]);
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
		$text[$i] = str_replace("—", "", $text[$i]);
		$text[$i] = str_replace("»", "", $text[$i]);
		$text[$i] = str_replace("«", "", $text[$i]);
		$text[$i] = str_replace("	", "", $text[$i]);
		$text[$i] = str_replace("“", "", $text[$i]);
		$text[$i] = str_replace("”", "", $text[$i]);
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