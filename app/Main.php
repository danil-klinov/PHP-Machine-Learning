<?php
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

define('N', 50);
define('THEME', 6);
define('NTEST', 5);

use Classification\NNClassifier;
use TextProcessing\Processing;
use TextProcessing\ConversionToVector;

$text=@$_GET["Text"];

	$nnFile = __DIR__ . '/nnFile.txt';
	$ctv = new ConversionToVector();
	$p = new Processing();
	$keyWords = $p->getKeyWords();
	
	if (file_exists($nnFile)) {
		$nn = NNClassifier::restoreFromFile($nnFile);
	} 
	else{
		echo "file not finded";
	
		$vectors = array();
		$result = array();
	
		for ($i = 0; $i < N; $i++){
			for ($theme = 0; $theme < THEME; $theme++){
					
				$file = file_get_contents(__DIR__ . '/DataSet/Text/' . $theme . '/' . $i . '.txt');
				$vectors[] = $ctv->buildTextVector($file,$keyWords);
				$result[] = $theme;
			}
		
		}
	
		$nn = new NNClassifier(count($keyWords), [128], [0,1,2,3,4,5]);
		$nn->train($vectors,$result);
		NNClassifier::saveToFile($nn,$nnFile);
	}
		
	if ($text == null){
		$result = array();
		for ($theme = 0; $theme < THEME; $theme++){
			$result[$theme] = 0;
			for ($i = 0; $i < 5; $i++){
				
				$file = file_get_contents(__DIR__ . '/DataSet/Test/' . $theme . '/' . $i . '.txt');
				$vector = $ctv->buildTextVector($file,$keyWords);
				
				if ($nn->predict($vector) == $theme) $result[$theme]++;
			}
			$result[$theme] = $result[$theme]/(float)NTEST;
			
		}
		foreach($result as $theme => $value){
			echo $theme . " = " . $value * 100 . "%";
		}
		/*for ($theme = 0; $theme < THEME; $theme++){
			for ($i = 0; $i < 5; $i++){
				
				$file = file_get_contents(__DIR__ . '/DataSet/Test/' . $theme . '/' . $i . '.txt');
				$vector = $ctv->buildTextVector($file,$keyWords);
				$result[] = $nn->predictSampleWithPercent($vector);
			}
		}
		foreach($result as $text => $output){
			foreach($output as $class => $value){
				$class = $p->getNameGenre($class);
				echo $class . "=" . round($value,2) * 100 . "% ";
			}		
			echo "<br>";
		}*/
	}
	else{
		$vector = $ctv->buildTextVector($text,$keyWords);
		$result[] = $nn->predictSampleWithPercent($vector);
		foreach($result as $text => $output){
			foreach($output as $class => $value){
				$class = $p->getNameGenre($class);
				echo $class . "=" . round($value,2) * 100 . "% ";
			}		
			echo "<br>";
		}
	}
?>
	
