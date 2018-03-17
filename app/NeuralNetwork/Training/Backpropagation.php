<?php

namespace NeuralNetwork\Training;
use NeuralNetwork\Neuron\HiddenNeuron;
use NeuralNetwork\Training\Sigma;

class Backpropagation
{

    private $learningRate;

    private $sigmas = [];

    private $prevSigmas = [];
    public function __construct(float $learningRate)
    {
        $this->setLearningRate($learningRate);
    }
    public function setLearningRate(float $learningRate): void
    {
        $this->learningRate = $learningRate;
    }

    public function backpropagate(array $layers, $targetClass): void
    {
        $layersNumber = count($layers);
        for ($i = $layersNumber; $i > 1; --$i) {
            $this->sigmas = [];
            foreach ($layers[$i - 1]->getNeurons() as $key => $neuron) {
                if ($neuron instanceof HiddenNeuron) {
                    $sigma = $this->getSigma($neuron, $targetClass, $key, $i == $layersNumber);
                    foreach ($neuron->getSynapses() as $synapse) {
                        $synapse->changeWeight($this->learningRate * $sigma * $synapse->getNeuron()->getOutput());
                    }
                }
            }
            $this->prevSigmas = $this->sigmas;
        }

        $this->sigmas = [];
        $this->prevSigmas = [];
    }
    private function getSigma(HiddenNeuron $neuron, int $targetClass, int $key, bool $lastLayer): float
    {
        $neuronOutput = $neuron->getOutput();
        $sigma = $neuron->getDerivative();
        if ($lastLayer) {
            $value = 0;
            if ($targetClass === $key) {
                $value = 1;
            }
            $sigma *= ($value - $neuronOutput);
        } else {
            $sigma *= $this->getPrevSigma($neuron);
        }
        $this->sigmas[] = new Sigma($neuron, $sigma);
        return $sigma;
    }
    private function getPrevSigma(HiddenNeuron $neuron): float
    {
        $sigma = 0.0;
        foreach ($this->prevSigmas as $neuronSigma) {
            $sigma += $neuronSigma->getSigmaForNeuron($neuron);
        }
        return $sigma;
    }
}