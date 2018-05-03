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

	public function predictSampleWithPercent(array $sample)
    {
        $output = $this->setInput($sample)->getOutput();
        $predicted = array();
        foreach ($output as $class => $value) {
            $predicted[$this->classes[$class]] = $value;
        }
        return $predicted;
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
	
	public static function saveToFile(NNClassifier $nnclassifier, string $file)
    {
        $serialized = serialize($nnclassifier);
        if (empty($serialized)) {
            throw new SerializeException('Class can not be serialized');
        }
        $result = file_put_contents($file, $serialized, LOCK_EX);
        if ($result === false) {
            throw new FileException('File cant be saved.');
        }
    }
	
	public static function restoreFromFile(string $file)
    {
        if (!file_exists($file) || !is_readable($file)) {
            throw new FileException('File cant be open.');
        }
        $object = unserialize(file_get_contents($file));
        if ($object === false) {
            throw new SerializeException('File cant be unserialized.');
        }
        return $object;
    }
}