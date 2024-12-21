<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatiereRepository::class)]
class Matiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    /**
     * @var Collection<int, Chapitre>
     */
    #[ORM\OneToMany(targetEntity: Chapitre::class, mappedBy: 'matiere')]
    private Collection $ChapitresMatiere;

    public function __construct()
    {
        $this->ChapitresMatiere = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Chapitre>
     */
    public function getChapitresMatiere(): Collection
    {
        return $this->ChapitresMatiere;
    }

    public function addChapitresMatiere(Chapitre $chapitresMatiere): static
    {
        if (!$this->ChapitresMatiere->contains($chapitresMatiere)) {
            $this->ChapitresMatiere->add($chapitresMatiere);
            $chapitresMatiere->setMatiere($this);
        }

        return $this;
    }

    public function removeChapitresMatiere(Chapitre $chapitresMatiere): static
    {
        if ($this->ChapitresMatiere->removeElement($chapitresMatiere)) {
            // set the owning side to null (unless already changed)
            if ($chapitresMatiere->getMatiere() === $this) {
                $chapitresMatiere->setMatiere(null);
            }
        }

        return $this;
    }
}
