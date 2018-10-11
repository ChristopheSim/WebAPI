<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BreweryRepository")
 */
class Brewery
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
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $website;

    /**
     * One Brewery has Many Beers.
     * @ORM\OneToMany(targetEntity="Beer", mappedBy="brewery")
     * @Assert\NotBlank()
     */
    private $beers;

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

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function __construct() {
        $this->beers = new ArrayCollection();
    }

    public function getBeers(): ?ArrayCollection
    {
        return $this->beers;
    }

    public function addBeer(? Beer $beer): self
    {
        $this->beers[] = $beer;

        return $this;
    }

    public function removeBeer(? Beer $beer): self
    {
        $index = array_search($beer, $this->beers);
        if ( $index !== false ) {
          unset( $this->beers[$index] );
        }

        return $this;
    }
}
