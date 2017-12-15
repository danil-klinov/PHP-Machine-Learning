<?php

namespace NeuralNetwork\Neuron;
use NeuralNetwork\ActivationFunction\ActivationFunctionInterface;
use NeuralNetwork\ActivationFunction\Sigmoid;
use NeuralNetwork\Synapse;
class HiddenNeuron implements NeuronInterface
{

    protected $synapses = [];
    protected $activationFunction;
    protected $output;
	
    public function __construct(ActivationFunctionInterface $activationFunction )
    {
        $this->activationFunction = $activationFunction;
        $this->synapses = [];
        $this->output = 0;
    }
    public function addSynapse(Synapse $synapse)
    {
        $this->synapses[] = $synapse;
    }
    public function getSynapses(): array
    {
        return $this->synapses;
    }
	
    public function getOutput(): float
    {
        if ($this->output === 0) {
            $sum = 0;
            foreach ($this->synapses as $synapse) {
                $sum += $synapse->getOutput();
            }
            $this->output = $this->activationFunction->execute($sum);
        }
        return $this->output;
    }
    public function zeroToOutput()
    {
        $this->output = 0;
    }
}