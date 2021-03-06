<?php

namespace App\Entity;

use App\Repository\MaterialRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MaterialRepository::class)
 */
class Material
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $MaterialName;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\GreaterThan(0)
     */
    private $MaterialPrice;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $MaterialDescription;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan(0)
     */
    private $MaterialAmount;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $MaterialMeasure;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="Material")
     */
    private $Service;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaterialName(): ?string
    {
        return $this->MaterialName;
    }

    public function setMaterialName(string $MaterialName): self
    {
        $this->MaterialName = $MaterialName;

        return $this;
    }

    public function getMaterialPrice(): ?string
    {
        return $this->MaterialPrice;
    }

    public function setMaterialPrice(string $MaterialPrice): self
    {
        $this->MaterialPrice = $MaterialPrice;

        return $this;
    }

    public function getMaterialDescription(): ?string
    {
        return $this->MaterialDescription;
    }

    public function setMaterialDescription(?string $MaterialDescription): self
    {
        $this->MaterialDescription = $MaterialDescription;

        return $this;
    }

    public function getMaterialAmount(): ?int
    {
        return $this->MaterialAmount;
    }

    public function setMaterialAmount(int $MaterialAmount): self
    {
        $this->MaterialAmount = $MaterialAmount;

        return $this;
    }

    public function getMaterialMeasure(): ?string
    {
        return $this->MaterialMeasure;
    }

    public function setMaterialMeasure(string $MaterialMeasure): self
    {
        $this->MaterialMeasure = $MaterialMeasure;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->Service;
    }

    public function setService(?Service $Service): self
    {
        $this->Service = $Service;

        return $this;
    }
}
