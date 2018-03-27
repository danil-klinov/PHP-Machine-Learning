<?php

namespace TextProcessing;
/**
 * Created by PhpStorm.
 * User: katemrrr
 * Date: 18.03.18
 * Time: 23:33
 */
use TextProcessing\Processing;

class ConversionToVector 
{
	function buildTextVector($file,$keyWords) {

		$arr = prepareText($file);
		$vector = array();
		$result = array();
		foreach (array_count_values($arr) as $key => $value) {
				$vector[$key] = $value;
		}
		for ($i = 0; $i < count($keyWords); $i++){
			$result[$i] = 0;
			if (array_key_exists($keyWords[$i], $vector)) {
				$result[$i] = $vector[$keyWords[$i]]
			}
		}
		return $result;

	}
	
	function prepareText($file) {
		$p = new Processing();
		$text = $p->getAllWords($file);
		$text = $p->deleteStopWords($text);
		$text = $p->doStemmWithText($text);
		return $text;
	}
	
}