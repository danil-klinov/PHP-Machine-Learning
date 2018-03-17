<?php
namespace NeuralNetwork;
use NeuralNetwork\Neuron\HiddenNeuron;
use NeuralNetwork\Neuron\InputNeuron;
use NeuralNetwork\ActivationFunction\ActivationFunctionInterface;
class Layer
{

    private $neurons = [];

    public function __construct(int $quantity = 0, string $neuronClass = HiddenNeuron::class, ?ActivationFunctionInterface $activationFunction = null )
    {

        for ($i = 0; $i < $quantity; ++$i) {
            $this->neurons[] = $this->createNeuron($neuronClass, $activationFunction);
        }
    }
    public function addNeuron(NeuronInterface $neuron)
    {
        $this->neurons[] = $neuron;
    }
    public function getNeurons(): array
    {
        return $this->neurons;
    }

    private function createNeuron(string $neuronClass, ?ActivationFunctionInterface $activationFunction )
    {
        if ($neuronClass == HiddenNeuron::class) {
            return new HiddenNeuron($activationFunction);
        }
		if ($neuronClass == InputNeuron::class) {
            return new InputNeuron();
        }

    }
}