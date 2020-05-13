<?php

namespace App\Entity;

use App\Repository\MotifsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MotifsRepository::class)
 */
class Motifs
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="json")
     */
    private $entitys = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $snid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntitys(): ?array
    {
        return $this->entitys;
    }

    public function setEntitys(array $entitys): self
    {
        $this->entitys = $entitys;

        return $this;
    }

    public function getSnid(): ?string
    {
        return $this->snid;
    }

    public function setSnid(string $snid): self
    {
        $this->snid = $snid;

        return $this;
    }
}
