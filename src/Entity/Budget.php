<?php

namespace App\Entity;

use App\Repository\BudgetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\CategorieBudget;
use App\DTO\BudgetDTO;

/**
 * @ORM\Entity(repositoryClass=BudgetRepository::class)
 */
class Budget
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")

     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;


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


 
   /**
     * @ORM\ManyToOne(targetEntity=CategorieBudget::class, inversedBy="budgets")
     *  * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity=Incomes::class, inversedBy="budget")
     */
    private $incomes;

  

    public function getCategorie(): ?CategorieBudget
    {
        return $this->categorie;
    }

    public function setCategorie(?CategorieBudget $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

/**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getIncomes(): ?Incomes
    {
        return $this->incomes;
    }

    public function setIncomes(?Incomes $incomes): self
    {
        $this->incomes = $incomes;

        return $this;
    }


    
}

