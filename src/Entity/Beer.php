<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BeerRepository")
 */
class Beer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     */
    private $volume;

    /**
     * Many Beers have One Type.
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="beers")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * Many Beers have One Brewery.
     * @ORM\ManyToOne(targetEntity="Brewery", inversedBy="beers")
     * @ORM\JoinColumn(name="brewery_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $brewery;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getVolume(): ?float
    {
        return $this->volume;
    }

    public function setVolume(float $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getBrewery(): ?Brewery
    {
        return $this->brewery;
    }

    public function setBrewery(Brewery $brewery): self
    {
        $this->brewery = $brewery;

        return $this;
    }
}
