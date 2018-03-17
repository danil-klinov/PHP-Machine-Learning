<?php

namespace Classification;

interface Classifier 
{
    public function train(array $samples, array $targets);
    public function predict(array $samples);
}