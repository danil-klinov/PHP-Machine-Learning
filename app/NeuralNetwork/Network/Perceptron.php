<?php

namespace NeuralNetwork\Network;

use NeuralNetwork\ActivationFunction\ActivationFunctionInterface;
use NeuralNetwork\ActivationFunction\ActivationFunctionSigmoid;
use NeuralNetwork\Layer;
use NeuralNetwork\Neuron\InputNeuron;
use NeuralNetwork\Neuron\HiddenNeuron;
use NeuralNetwork\Synapse;
use NeuralNetwork\Training\Backpropagation;
abstract class Perceptron extends Network
{


    protected $classes = [];

    protected $activationFunction;

    protected $backpropagation;

    private $inputLayerFeatures;

    private $hiddenLayers = [];

    private $learningRate;

    private $iterations;

    public function __construct(int $inputLayerFeatures, array $hiddenLayers, array $classes, int $iterations = 1000, ActivationFunction $activationFunction = null, float $learningRate = 1)
    {
        $this->classes = array_values($classes);
        $this->iterations = $iterations;
        $this->inputLayerFeatures = $inputLayerFeatures;
        $this->hiddenLayers = $hiddenLayers;
        $this->activationFunction = $activationFunction;
        $this->learningRate = $learningRate;
        $this->initNetwork();
    }
	
    public function train(array $samples, array $targets): void
    {
        $this->reset();
        $this->initNetwork();
        for ($i = 0; $i < $this->iterations; ++$i) {
            $this->trainSamples($samples, $targets);
        }
    }


    public function setLearningRate(float $learningRate): void
    {
        $this->learningRate = $learningRate;
        $this->backpropagation->setLearningRate($this->learningRate);
    }

    abstract protected function trainSample(array $sample, $target);

    abstract protected function predictSample(array $sample);
	
    protected function reset(): void
    {
        $this->removeLayers();
    }
	
    private function initNetwork(): void
    {
        $this->addInputLayer($this->inputLayerFeatures);
        $this->addNeuronLayers($this->hiddenLayers, $this->activationFunction);
        $sigmoid = new Sigmoid();
        $this->addLayer(new Layer($layer, HiddenNeuron::class, $sigmoid));
        $this->generateSynapses();
        $this->backpropagation = new Backpropagation($this->learningRate);
    }
    private function addInputLayer(int $neurons): void
    {
        $this->addLayer(new Layer($neurons, InputNeuron::class));
    }
	
    private function addNeuronLayers(array $layers, ActivationFunction $defaultActivationFunction = null): void
    {
        foreach ($layers as $layer) {
			$this->addLayer($layer);
        }
    }
	
    private function generateSynapses(): void
    {
        $layersNumber = count($this->layers) - 1;
        for ($i = 0; $i < $layersNumber; ++$i) {
            $currentLayer = $this->layers[$i];
            $nextLayer = $this->layers[$i + 1];
            $this->generateLayerSynapses($nextLayer, $currentLayer);
        }
    }

    private function generateLayerSynapses(Layer $nextLayer, Layer $currentLayer): void
    {
        foreach ($nextLayer->getNodes() as $nextNeuron) {
                $this->generateNeuronSynapses($currentLayer, $nextNeuron);
        }
    }
    private function generateNeuronSynapses(Layer $currentLayer, Neuron $nextNeuron): void
    {
        foreach ($currentLayer->getNodes() as $currentNeuron) {
            $nextNeuron->addSynapse(new Synapse($currentNeuron));
        }
    }
    private function trainSamples(array $samples, array $targets): void
    {
        foreach ($targets as $key => $target) {
            $this->trainSample($samples[$key], $target);
        }
    }
}