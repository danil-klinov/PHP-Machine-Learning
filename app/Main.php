<?php
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

use Classification\NNClassifier;



    $nn = new NNClassifier(3, [8], ['a','b','c']);
	$nn->train(
            [[1, 0, 1], [0, 1, 0], [1, 1, 0], [0, 0, 1], [0,0,0]],
            ['a', 'b', 'a', 'b', 'c']
        );
    echo $nn->predict([0, 0, 0]);
