<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $identifiant;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $prenom;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: ListeTaches::class)]
    private $listeTaches;

    public function __construct()
    {
        $this->listeTaches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifiant(): ?string
    {
        return $this->identifiant;
    }

    public function setIdentifiant(string $identifiant): self
    {
        $this->identifiant = $identifiant;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection<int, ListeTaches>
     */
    public function getListeTaches(): Collection
    {
        return $this->listeTaches;
    }

    public function addListeTach(ListeTaches $listeTach): self
    {
        if (!$this->listeTaches->contains($listeTach)) {
            $this->listeTaches[] = $listeTach;
            $listeTach->setUtilisateur($this);
        }

        return $this;
    }

    public function removeListeTach(ListeTaches $listeTach): self
    {
        if ($this->listeTaches->removeElement($listeTach)) {
            // set the owning side to null (unless already changed)
            if ($listeTach->getUtilisateur() === $this) {
                $listeTach->setUtilisateur(null);
            }
        }

        return $this;
    }
}
