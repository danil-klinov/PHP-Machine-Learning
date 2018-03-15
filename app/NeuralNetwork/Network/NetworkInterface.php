<?php

namespace NeuralNetwork\Network;
interface NetworkInterface
{

    public function setInput($input): self;
    public function getOutput(): array;
    public function addLayer(Layer $layer);

    public function getLayers(): array;
}