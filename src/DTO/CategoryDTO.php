<?php
// TransactionDTO.php

namespace App\DTO;

// src/DTO/CategoryDTO.php



class CategoryDTO
{
    private $nomCategorie;

    // Getter and setter methods...

    public function getNomCategorie(): ?string
    {
        return $this->nomCategorie;
    }

    public function setNomCategorie(?string $nomCategorie): self
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }
}
