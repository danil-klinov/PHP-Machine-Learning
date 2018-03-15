<?php

namespace Classification;

interface Classifier 
{
    public function trainSample(array $samples, array $targets);
    public function predictSample(array $samples);
}