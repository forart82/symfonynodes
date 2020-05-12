<?php

namespace App\Entity;

use App\Repository\SymfonyNodesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\Cast\Array_;

/**
 * @ORM\Entity(repositoryClass=SymfonyNodesRepository::class)
 */
class SymfonyNodes
{
    private $em;

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

    protected $connections;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
        $this->connections= new ArrayCollection();
    }

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

    public function getConnections()
    {
        return $this->connections;
    }

    public function addConnection($connection)
    {
        if(!empty($connection))
        {
            $this->em->persist($connection);
            $this->em->flush();
        }
    }

    public function removeConnection($connection)
    {

    }

}
