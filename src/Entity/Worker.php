<?php

namespace App\Entity;

use App\Repository\WorkerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WorkerRepository::class)
 */
class Worker
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $WorkerFirstName;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $WorkerMiddleName;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $WorkerLastName;

    /**
     * @ORM\Column(type="string", length=11)
     */
    private $WorkerPhone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWorkerFirstName(): ?string
    {
        return $this->WorkerFirstName;
    }

    public function setWorkerFirstName(string $WorkerFirstName): self
    {
        $this->WorkerFirstName = $WorkerFirstName;

        return $this;
    }

    public function getWorkerMiddleName(): ?string
    {
        return $this->WorkerMiddleName;
    }

    public function setWorkerMiddleName(string $WorkerMiddleName): self
    {
        $this->WorkerMiddleName = $WorkerMiddleName;

        return $this;
    }

    public function getWorkerLastName(): ?string
    {
        return $this->WorkerLastName;
    }

    public function setWorkerLastName(string $WorkerLastName): self
    {
        $this->WorkerLastName = $WorkerLastName;

        return $this;
    }

    public function getWorkerPhone(): ?string
    {
        return $this->WorkerPhone;
    }

    public function setWorkerPhone(string $WorkerPhone): self
    {
        $this->WorkerPhone = $WorkerPhone;

        return $this;
    }
}
