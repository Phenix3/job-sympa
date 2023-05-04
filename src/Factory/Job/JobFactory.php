<?php

namespace App\Factory\Job;

use App\Entity\Job\Job;
use App\Factory\CountryFactory;
use App\Factory\User\EmployerFactory;
use App\Repository\Job\JobRepository;
use function Zenstruck\Foundry\lazy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Job>
 *
 * @method        Job|Proxy create(array|callable $attributes = [])
 * @method static Job|Proxy createOne(array $attributes = [])
 * @method static Job|Proxy find(object|array|mixed $criteria)
 * @method static Job|Proxy findOrCreate(array $attributes)
 * @method static Job|Proxy first(string $sortedField = 'id')
 * @method static Job|Proxy last(string $sortedField = 'id')
 * @method static Job|Proxy random(array $attributes = [])
 * @method static Job|Proxy randomOrCreate(array $attributes = [])
 * @method static JobRepository|RepositoryProxy repository()
 * @method static Job[]|Proxy[] all()
 * @method static Job[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Job[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Job[]|Proxy[] findBy(array $attributes)
 * @method static Job[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Job[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class JobFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
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
            'city' => self::faker()->city(),
            'createdAt' => self::faker()->dateTime(),
            'deadline' => self::faker()->dateTimeBetween('-5 days', '+25 days'),
            'description' => self::faker()->text(300),
            'education' => self::faker()->text(),
            'experience' => self::faker()->numberBetween(1, 6),
            'fullAddress' => self::faker()->address(),
            'isCreatedByAdmin' => self::faker()->boolean(),
            'isFreelance' => self::faker()->boolean(),
            'isSuspended' => self::faker()->boolean(),
            'location' => self::faker()->city(),
            'otherBenefits' => self::faker()->text(),
            'publishedAt' => self::faker()->dateTimeBetween('-5 days', 'now'),
            'requirements' => self::faker()->text(),
            'responsibilities' => self::faker()->text(),
            'salaryMax' => self::faker()->randomNumber(8),
            'salaryMin' => self::faker()->randomNumber(5),
            // 'slug' => self::faker()->text(255),
            'title' => self::faker()->jobTitle(),
            'company' => lazy(fn() => EmployerFactory::random()),
            'type' => lazy(fn() => TypeFactory::random()),
            'country' => lazy(fn() => CountryFactory::random()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Job $job): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Job::class;
    }
}
