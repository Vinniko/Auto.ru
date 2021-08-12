<?php

namespace App\Factory;

use App\Entity\Country;
use App\Repository\CountryRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Country|Proxy createOne(array $attributes = [])
 * @method static Country[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Country|Proxy find($criteria)
 * @method static Country|Proxy findOrCreate(array $attributes)
 * @method static Country|Proxy first(string $sortedField = 'id')
 * @method static Country|Proxy last(string $sortedField = 'id')
 * @method static Country|Proxy random(array $attributes = [])
 * @method static Country|Proxy randomOrCreate(array $attributes = [])
 * @method static Country[]|Proxy[] all()
 * @method static Country[]|Proxy[] findBy(array $attributes)
 * @method static Country[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Country[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static CountryRepository|RepositoryProxy repository()
 * @method Country|Proxy create($attributes = [])
 */
final class CountryFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'title' => self::faker()->unique()->country(),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ];
    }

    protected function initialize(): self
    {
        return $this;
    }

    protected static function getClass(): string
    {
        return Country::class;
    }
}
