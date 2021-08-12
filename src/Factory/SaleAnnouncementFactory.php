<?php

namespace App\Factory;

use App\Entity\SaleAnnouncement;
use App\Repository\SaleAnnouncementRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static SaleAnnouncement|Proxy createOne(array $attributes = [])
 * @method static SaleAnnouncement[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static SaleAnnouncement|Proxy find($criteria)
 * @method static SaleAnnouncement|Proxy findOrCreate(array $attributes)
 * @method static SaleAnnouncement|Proxy first(string $sortedField = 'id')
 * @method static SaleAnnouncement|Proxy last(string $sortedField = 'id')
 * @method static SaleAnnouncement|Proxy random(array $attributes = [])
 * @method static SaleAnnouncement|Proxy randomOrCreate(array $attributes = [])
 * @method static SaleAnnouncement[]|Proxy[] all()
 * @method static SaleAnnouncement[]|Proxy[] findBy(array $attributes)
 * @method static SaleAnnouncement[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static SaleAnnouncement[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static SaleAnnouncementRepository|RepositoryProxy repository()
 * @method SaleAnnouncement|Proxy create($attributes = [])
 */
final class SaleAnnouncementFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'price' => self::faker()->randomFloat(2, 150, 150000),
            'auto' => AutoFactory::new()->create(),
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
        return SaleAnnouncement::class;
    }
}
