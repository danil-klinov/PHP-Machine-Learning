<?php
namespace NeuralNetwork;
use NeuralNetwork\Neuron\NeuronInterface;
class Synapse
{

    protected $weight;
    protected $neuron;

    public function __construct(NeuronInterface $neuron, ?float $weight = null)
    {
        $this->neuron = $neuron;
        $this->weight = $weight ?: $this->generateRandomWeight();;
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
	
	protected function generateRandomWeight(): float
    {
        return 1 / random_int(5, 25) * (random_int(0, 1) ? -1 : 1);
    }

}