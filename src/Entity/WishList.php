<?php

namespace App\Entity;

use App\Repository\WishListRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WishListRepository::class)
 */
class WishList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $wish;

    /**
     * @ORM\Column(type="float")
     */
    private $montantwish;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWish(): ?string
    {
        return $this->wish;
    }

    public function setWish(string $wish): self
    {
        $this->wish = $wish;

        return $this;
    }

    public function getMontantwish(): ?float
    {
        return $this->montantwish;
    }

    public function setMontantwish(float $montantwish): self
    {
        $this->montantwish = $montantwish;

        return $this;
    }
}
