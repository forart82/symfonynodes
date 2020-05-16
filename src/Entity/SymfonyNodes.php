<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SymfonyNodesRepository::class)
 */
class SymfonyNodes
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="string")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Services\ORM\IdGenerator")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $snid;

    protected $texts;
    protected $motifs;
    protected $strings;
    protected $types;
    protected $images;

    public function __construct()
    {
        $this->texts= new ArrayCollection();
        $this->motifs= new ArrayCollection();
        $this->strings= new ArrayCollection();
        $this->types= new ArrayCollection();
        $this->images= new ArrayCollection();
    }

    public function getId(): ?string
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

    // TODO set getter and setter values

    public function getTexts()
    {
        return $this->texts;
    }

    public function addText($text)
    {
    }

    public function removeText($text)
    {
    }

    public function getMotifs()
    {
        return $this->motifs;
    }

    public function addMotif($motif)
    {

    }

    public function removeMotif($motif)
    {

    }

    public function getTypes()
    {
        return $this->types;
    }

    public function addType($type)
    {
    }

    public function removeType($type)
    {

    }

    public function getStrings()
    {
        return $this->strings;
    }

    public function addString($string)
    {

    }

    public function removeString($string)
    {

    }

    public function getImages()
    {
        return $this->images;
    }

    public function addImage($image)
    {

    }

    public function removeImage($image)
    {

    }
}
