<?php

namespace App\Entity;

use App\Repository\ExpensesRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Transaction;

/**
 * @ORM\Entity(repositoryClass=ExpensesRepository::class)
 */
class Expenses
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private $montantTotal= 0.0;

    // Add getter and setter for montantTotal

    public function getMontantTotal(): ?float
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(float $montantTotal): self
    {
        $this->montantTotal = $montantTotal;

        return $this;
    }

    



 
}
