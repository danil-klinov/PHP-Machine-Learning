<?php
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

define('N', 4);
define('THEME', 6);

use Classification\NNClassifier;
use TextProcessing\Processing;
use TextProcessing\ConversionToVector;

	$processing = new Processing();
	$keyWords = $p.getKeyWords();
	$ctv = new ConversionToVector();
	
	$vectors = array();
	$result = array();
	
	for ($i = 0; $i < N; $i++){
		for ($theme = 0; $theme < THEME; $theme++){
			//do right filepath
			$file = file_get_contents($q . ".txt");
			
			$vectors[] = $ctv->buildTextVector($file,$keyWords);
			$result[] = $theme;
		}
		
	}
	
	
	
	
    $nn = new NNClassifier(count($keyWords), [8], [0,1,2,3,4,5]);
	$nn->train(
            $vectors,
            $result
        );
    echo $nn->predict($vectors[0]);
