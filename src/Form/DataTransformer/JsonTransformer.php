<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use function Symfony\Component\String\u;

class JsonTransformer implements DataTransformerInterface
{

    public function transform(mixed $value): mixed
    {
        /*if (!\is_array($value)) {
            throw new TransformationFailedException('Expected type array');
        }*/

        return u(', ')->join($value ?? [])->toString();
    }

    public function reverseTransform(mixed $value): mixed
    {
        return explode(', ', $value);
    }
}