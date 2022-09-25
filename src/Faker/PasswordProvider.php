<?php

namespace App\Faker;

use App\Entity\User\Candidate;
use Faker\Generator;
use Faker\Provider\Base;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordProvider extends Base
{

    /**
     * @param Generator $generator
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(Generator $generator, private UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct($generator);
    }

    public function password(string $plainPassword): string
    {
        return $this->passwordHasher->hashPassword(new Candidate(), $plainPassword);
    }
}
