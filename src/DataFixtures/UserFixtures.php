<?php

namespace App\DataFixtures;

use App\Entity\User\Employer;
use App\Entity\User\Candidate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private \Faker\Generator $faker;

    /**
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $employer = new Employer();
            $employer
                ->setEmail($this->faker->email)
                ->setPassword($this->passwordHasher->hashPassword($employer, '123456'))
                ->setRoles(['ROLE_EMPLOYER'])
                ->setUsername($this->faker->userName);

            $manager->persist($employer);
            $manager->flush();
        }

        for ($i = 0; $i < 10; $i++) {
            $candidate = new Candidate();
            $candidate
                ->setEmail($this->faker->email)
                ->setPassword($this->passwordHasher->hashPassword($candidate, '123456'))
                ->setRoles(['ROLE_CANDIDATE'])
                ->setUsername($this->faker->userName);

            $manager->persist($candidate);
            $manager->flush();
        }
    }
}
