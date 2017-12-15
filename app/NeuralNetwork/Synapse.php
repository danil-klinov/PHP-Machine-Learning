<?php
namespace NeuralNetwork;
use NeuralNetwork\Neuron;
class Synapse
{

    protected $weight;
    protected $neuron;

    public function __construct(NeuronInterface $neuron, float $weight)
    {
        $this->neuron = $neuron;
        $this->weight = $weight;
    }
    public function getOutput(): float
    {
        return $this->weight * $this->neuron->getOutput();
    }
	
    public function changeWeight(float $weight)
    {
        $this->weight += $weight;
    }
    public function getWeight(): float
    {
        return $this->weight;
    }
	
    public function getNeuron(): NeuronInterface
    {
        return $this->neuron;
    }

}