<?php

namespace NeuralNetwork\Neuron;
class InputNeuron implements NeuronInterface
{

    private $input;
    public function __construct(float $input = 0.0)
    {
        $this->input = $input;
    }
    public function getOutput(): float
    {
        return $this->input;
    }
    public function setInput(float $input)
    {
        $this->input = $input;
    }
}