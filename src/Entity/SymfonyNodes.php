<?php

namespace App\Entity;

use App\Repository\SymfonyNodesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SymfonyNodesRepository::class)
 */
class SymfonyNodes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="bigint")
     */
    private $snid;

    /**
     * @ORM\Column(type="bigint")
     */
    private $iid;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIid(): ?string
    {
        return $this->iid;
    }

    public function setIid(string $iid): self
    {
        $this->iid = $iid;

        return $this;
    }
}
