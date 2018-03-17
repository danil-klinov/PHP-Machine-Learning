<?php
namespace NeuralNetwork\Training;
use NeuralNetwork\Neuron\HiddenNeuron;
class Sigma
{
    private $neuron;

    private $sigma;
	
    public function __construct(HiddenNeuron $neuron, float $sigma)
    {
        $this->neuron = $neuron;
        $this->sigma = $sigma;
    }
    public function getNeuron(): Neuron
    {
        return $this->neuron;
    }
    public function getSigma(): float
    {
        return $this->sigma;
    }
    public function getSigmaForNeuron(HiddenNeuron $neuron): float
    {
        $sigma = 0.0;
        foreach ($this->neuron->getSynapses() as $synapse) {
            if ($synapse->getNeuron() == $neuron) {
                $sigma += $synapse->getWeight() * $this->getSigma();
            }
        }
        return $sigma;
    }
}