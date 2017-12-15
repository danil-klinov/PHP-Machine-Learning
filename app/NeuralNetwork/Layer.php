<?php
namespace NeuralNetwork;
use NeuralNetwork\Neuron\HiddenNeuron;
class Layer
{

    private $neurons = [];

    public function __construct(int $quantity = 0, string $neuronClass, ActivationFunctionInterface $activationFunction = null )
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

    private function createNeuron(string $neuronClass, ActivationFunction $activationFunction ): NeuronInterface
    {
        if ($neuronClass == HiddenNeuron::class) {
            return new HiddenNeuron($activationFunction);
        }
		if ($neuronClass == InputNeuron::class) {
            return new InputNeuron();
        }

    }
}