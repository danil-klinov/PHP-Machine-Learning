<?php

namespace Classification;
use NeuralNetwork\Network\Perceptron;

class NNClassifier extends Perceptron implements Classifier
{
    public function predictSample(array $sample)
    {
        $output = $this->setInput($sample)->getOutput();
        $predictedClass = null;
        $max = 0;
        foreach ($output as $class => $value) {
            if ($value > $max) {
                $predictedClass = $class;
                $max = $value;
            }
        }
        return $this->classes[$predictedClass];
    }

    public function trainSample(array $sample, $target): void
    {
        $this->setInput($sample)->getOutput();
        $this->backpropagation->backpropagate($this->getLayers(), $this->getTargetClass($target));
    }
	
	public function getTargetClass($target): int
    {
        return array_search($target, $this->classes, true);
    }
}