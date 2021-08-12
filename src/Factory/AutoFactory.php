<?php

namespace App\Factory;

use App\Entity\Auto;
use App\Entity\Country;
use App\Repository\AutoRepository;
use App\Repository\CountryRepository;
use Faker\Provider\DateTime;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Auto|Proxy createOne(array $attributes = [])
 * @method static Auto[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Auto|Proxy find($criteria)
 * @method static Auto|Proxy findOrCreate(array $attributes)
 * @method static Auto|Proxy first(string $sortedField = 'id')
 * @method static Auto|Proxy last(string $sortedField = 'id')
 * @method static Auto|Proxy random(array $attributes = [])
 * @method static Auto|Proxy randomOrCreate(array $attributes = [])
 * @method static Auto[]|Proxy[] all()
 * @method static Auto[]|Proxy[] findBy(array $attributes)
 * @method static Auto[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Auto[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static AutoRepository|RepositoryProxy repository()
 * @method Auto|Proxy create($attributes = [])
 */
final class AutoFactory extends ModelFactory
{
    private $country_repository;

    public function __construct(CountryRepository $country_repository)
    {
        parent::__construct();
        $this->country_repository = $country_repository;
    }

    protected function getDefaults(): array
    {
        return [
            'mark' => self::faker()->word(),
            'build_year' => \DateTime::createFromFormat('Y-m-d H:i:s', DateTime::date('Y-m-d H:i:s')),
            'country' => CountryFactory::new()->create(),
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
        return Auto::class;
    }
}
