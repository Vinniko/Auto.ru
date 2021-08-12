<?php

namespace App\Entity;

use App\Repository\SaleAnnouncementRepository;
use App\Traits\EntityLifecicleTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SaleAnnouncementRepository::class)
 * @ORM\Table(name="`sale_announcements`")
 * @ORM\HasLifecycleCallbacks
 */
class SaleAnnouncement
{
    use EntityLifecicleTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\OneToOne(targetEntity=Auto::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="auto_id", referencedColumnName="id")
     */
    private $auto;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getAuto(): ?Auto
    {
        return $this->auto;
    }

    public function setAuto(Auto $auto): self
    {
        $this->auto = $auto;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }
}
