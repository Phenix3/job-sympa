<?php

namespace App\Factory\User;

use App\Entity\User\Employer;
use App\Repository\User\EmployerRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Employer>
 *
 * @method        Employer|Proxy create(array|callable $attributes = [])
 * @method static Employer|Proxy createOne(array $attributes = [])
 * @method static Employer|Proxy find(object|array|mixed $criteria)
 * @method static Employer|Proxy findOrCreate(array $attributes)
 * @method static Employer|Proxy first(string $sortedField = 'id')
 * @method static Employer|Proxy last(string $sortedField = 'id')
 * @method static Employer|Proxy random(array $attributes = [])
 * @method static Employer|Proxy randomOrCreate(array $attributes = [])
 * @method static EmployerRepository|RepositoryProxy repository()
 * @method static Employer[]|Proxy[] all()
 * @method static Employer[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Employer[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Employer[]|Proxy[] findBy(array $attributes)
 * @method static Employer[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Employer[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class EmployerFactory extends ModelFactory
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
            'about' => self::faker()->text(),
            'address' => self::faker()->address(),
            'avatarName' => self::faker()->text(),
            'birth' => self::faker()->dateTime(),
            'ceo' => self::faker()->name(),
            'city' => self::faker()->city(),
            'createdAt' => self::faker()->dateTime(),
            'email' => self::faker()->safeEmail(),
            'establishedAt' => self::faker()->dateTime('-2 years'),
            'isVerified' => self::faker()->boolean(80),
            'location' => [],
            'notificationsReadAt' => self::faker()->dateTime(),
            'password' => '123456',
            'phone' => self::faker()->phoneNumber(),
            'roles' => [],
            'socialAccounts' => [],
            // 'updatedAt' => self::faker()->dateTime(),
            'username' => self::faker()->userName(),
            'viewCount' => self::faker()->randomNumber(3),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function(Employer $employer): void {
                $employer->setPassword($this->passwordHasher->hashPassword($employer, $employer->getPassword()));
            })
        ;
    }

    protected static function getClass(): string
    {
        return Employer::class;
    }
}
