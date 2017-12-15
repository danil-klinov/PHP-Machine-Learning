<?php
namespace NeuralNetwork\ActivationFunction;
interface ActivationFunctionInterface
{

    public function execute(float $value): float;
}