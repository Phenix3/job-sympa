<?php

namespace App\Factory\Job;

use App\Entity\Job\Type;
use App\Repository\Job\TypeRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Type>
 *
 * @method        Type|Proxy create(array|callable $attributes = [])
 * @method static Type|Proxy createOne(array $attributes = [])
 * @method static Type|Proxy find(object|array|mixed $criteria)
 * @method static Type|Proxy findOrCreate(array $attributes)
 * @method static Type|Proxy first(string $sortedField = 'id')
 * @method static Type|Proxy last(string $sortedField = 'id')
 * @method static Type|Proxy random(array $attributes = [])
 * @method static Type|Proxy randomOrCreate(array $attributes = [])
 * @method static TypeRepository|RepositoryProxy repository()
 * @method static Type[]|Proxy[] all()
 * @method static Type[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Type[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Type[]|Proxy[] findBy(array $attributes)
 * @method static Type[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Type[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class TypeFactory extends ModelFactory
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
            'description' => self::faker()->text(),
            'name' => self::faker()->text(255),
            // 'slug' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Type $type): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Type::class;
    }
}
