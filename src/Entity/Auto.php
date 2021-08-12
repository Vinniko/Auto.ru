<?php

namespace App\Entity;

use App\Repository\AutoRepository;
use App\Traits\EntityLifecicleTrait;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AutoRepository::class)
 * @ORM\Table(name="`autos`")
 * @ORM\HasLifecycleCallbacks
 */
class Auto
{
    use EntityLifecicleTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mark;

    /**
     * @ORM\Column(type="datetime")
     */
    private $build_year;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="autos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $country;


    public function __construct()
    {
        $this->saleAnnouncements = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMark(): ?string
    {
        return $this->mark;
    }

    public function setMark(string $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    public function getBuildYear(): ?DateTimeInterface
    {
        return $this->build_year;
    }

    public function setBuildYear(DateTimeInterface $build_year): self
    {
        $this->build_year = $build_year;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }
}
