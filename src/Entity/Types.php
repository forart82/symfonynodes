<?php

namespace App\Entity;

use App\Repository\TypesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypesRepository::class)
 */
class Types
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $snid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
