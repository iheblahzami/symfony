<?php

namespace App\Entity;

use App\Repository\IncomesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IncomesRepository::class)
 */
class Incomes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\Column(type="date")
     */
    private $mois;

    /**
     * @ORM\OneToMany(targetEntity=Budget::class, mappedBy="incomes")
     */
    private $budget;

    public function __construct()
    {
        $this->budget = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getMois(): ?\DateTimeInterface
    {
        return $this->mois;
    }

    public function setMois(\DateTimeInterface $mois): self
    {
        $this->mois = $mois;

        return $this;
    }

    /**
     * @return Collection<int, Budget>
     */
    public function getBudget(): Collection
    {
        return $this->budget;
    }

    public function addBudget(Budget $budget): self
    {
        if (!$this->budget->contains($budget)) {
            $this->budget[] = $budget;
            $budget->setIncomes($this);
        }

        return $this;
    }

    public function removeBudget(Budget $budget): self
    {
        if ($this->budget->removeElement($budget)) {
            // set the owning side to null (unless already changed)
            if ($budget->getIncomes() === $this) {
                $budget->setIncomes(null);
            }
        }

        return $this;
    }
}
