<?php

namespace App\Entity;

use App\Repository\TacheRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TacheRepository::class)]
class Tache
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\ManyToOne(targetEntity: ListeTaches::class, inversedBy: 'taches')]
    #[ORM\JoinColumn(nullable: false)]
    private $listeTache;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getListeTache(): ?ListeTaches
    {
        return $this->listeTache;
    }

    public function setListeTache(?ListeTaches $listeTache): self
    {
        $this->listeTache = $listeTache;

        return $this;
    }
}
