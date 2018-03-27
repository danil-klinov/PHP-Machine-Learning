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
		
		// to do right
		//foreach (array_count_values($arr) as $key => $value) {
		//	$vector[$key] = $value;
		//}

		return $vector;

	}
	
	function prepareText($file) {
		$p = new Processing();
		$text = $p->getAllWords($file);
		$text = $p->deleteStopWords($text);
		$text = $p->doStemmWithText($text);
		return $text;
	}
	
}