<?php

namespace NeuralNetwork\Network;
use NeuralNetwork\Layer;
use NeuralNetwork\Network\NetworkInterface;
use NeuralNetwork\Neuron\InputNeuron;
use NeuralNetwork\Neuron\HiddenNeuron;
abstract class Network implements NetworkInterface
{

    protected $layers = [];
    public function addLayer(Layer $layer): void
    {
        $this->layers[] = $layer;
    }

    public function getLayers(): array
    {
        return $this->layers;
    }
    public function removeLayers(): void
    {
        unset($this->layers);
    }
    public function getOutputLayer(): Layer
    {
        return $this->layers[count($this->layers) - 1];
    }
    public function getOutput(): array
    {
        $result = [];
        foreach ($this->getOutputLayer()->getNodes() as $neuron) {
            $result[] = $neuron->getOutput();
        }
        return $result;
    }

    public function setInput($input): Network
    {
        $firstLayer = $this->layers[0];
        foreach ($firstLayer->getNeurons() as $key => $neuron) {
            if ($neuron instanceof InputNeuron) {
                $neuron->setInput($input[$key]);
            }
        }
        foreach ($this->getLayers() as $layer) {
            foreach ($layer->getNeurons() as $neuron) {
                if ($neuron instanceof HiddenNeuron) {
                    $neuron->reset();
                }
            }
        }
        return $this;
    }
}