<?php

namespace NeuralNetwork\Network;

use NeuralNetwork\Layer;

interface NetworkInterface
{

    public function setInput($input);
    public function getOutput(): array;
    public function addLayer(Layer $layer);

    public function getLayers(): array;
}