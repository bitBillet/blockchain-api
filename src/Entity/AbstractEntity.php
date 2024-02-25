<?php

namespace App\Entity;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class AbstractEntity
{
    protected Serializer $serializer;

    public function __construct()
    {
        $this->serializer = new Serializer([new ObjectNormalizer()]);
    }

    public function toArray()
    {
        return $this->serializer->normalize($this);
    }
}
