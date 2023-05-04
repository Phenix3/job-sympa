<?php

namespace App\Factory\User;

use App\Entity\User\Candidate;
use App\Repository\User\CandidateRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Candidate>
 *
 * @method        Candidate|Proxy create(array|callable $attributes = [])
 * @method static Candidate|Proxy createOne(array $attributes = [])
 * @method static Candidate|Proxy find(object|array|mixed $criteria)
 * @method static Candidate|Proxy findOrCreate(array $attributes)
 * @method static Candidate|Proxy first(string $sortedField = 'id')
 * @method static Candidate|Proxy last(string $sortedField = 'id')
 * @method static Candidate|Proxy random(array $attributes = [])
 * @method static Candidate|Proxy randomOrCreate(array $attributes = [])
 * @method static CandidateRepository|RepositoryProxy repository()
 * @method static Candidate[]|Proxy[] all()
 * @method static Candidate[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Candidate[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Candidate[]|Proxy[] findBy(array $attributes)
 * @method static Candidate[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Candidate[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class CandidateFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'createdAt' => self::faker()->dateTime(),
            'email' => self::faker()->safeEmail(180),
            'isVerified' => self::faker()->boolean(80),
            'password' => '123456',
            'roles' => [],
            'updatedAt' => self::faker()->dateTime(),
            'username' => self::faker()->userName(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function(Candidate $candidate): void {
                $candidate->setPassword($this->passwordHasher->hashPassword($candidate, $candidate->getPassword()));
            })
        ;
    }

    protected static function getClass(): string
    {
        return Candidate::class;
    }
}
