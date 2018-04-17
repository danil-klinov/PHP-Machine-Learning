<?php

namespace NeuralNetwork\Neuron;
use NeuralNetwork\ActivationFunction\ActivationFunctionInterface;
use NeuralNetwork\ActivationFunction\ActivationFunctionSigmoid;
use NeuralNetwork\Synapse;
class HiddenNeuron implements NeuronInterface
{

    protected $synapses = [];
    protected $activationFunction;
    protected $output = 0.0;
	protected $z = 0.0;
	
    public function __construct(?ActivationFunctionInterface $activationFunction )
    {
        $this->activationFunction = $activationFunction ?: new ActivationFunctionSigmoid();
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
            $this->z = 0;
            foreach ($this->synapses as $synapse) {
                $this->z += $synapse->getOutput();
            }
            $this->output = $this->activationFunction->execute($this->z);
        }
        return $this->output;
    }
    public function reset()
    {
        $this->output = 0;
		$this->z = 0.0;
    }
	
	public function getDerivative(): float
    {
        return $this->activationFunction->differentiate($this->z, $this->output);
    }

}