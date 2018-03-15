<?php

namespace NeuralNetwork\ActivationFunction;
class ActivationFunctionSigmoid implements ActivationFunctionInterface
{

    public function execute(float $value): float
    {
        return 1 / (1 + exp(-$value));
    }
	
	public function differentiate($value, $computedvalue): float
    {
        return $computedvalue * (1 - $computedvalue);
    }
}