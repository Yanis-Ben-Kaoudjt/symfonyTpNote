<?php

namespace App\Entity;

use App\Repository\ChapitreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChapitreRepository::class)]
class Chapitre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[ORM\ManyToOne(inversedBy: 'ChapitresMatiere')]
    private ?Matiere $matiere = null;

    /**
     * @var Collection<int, Exercice>
     */
    #[ORM\OneToMany(targetEntity: Exercice::class, mappedBy: 'chapitre')]
    private Collection $ExercicesChapitre;

    public function __construct()
    {
        $this->ExercicesChapitre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): static
    {
        $this->matiere = $matiere;

        return $this;
    }

    /**
     * @return Collection<int, Exercice>
     */
    public function getExercicesChapitre(): Collection
    {
        return $this->ExercicesChapitre;
    }

    public function addExercicesChapitre(Exercice $exercicesChapitre): static
    {
        if (!$this->ExercicesChapitre->contains($exercicesChapitre)) {
            $this->ExercicesChapitre->add($exercicesChapitre);
            $exercicesChapitre->setChapitre($this);
        }

        return $this;
    }

    public function removeExercicesChapitre(Exercice $exercicesChapitre): static
    {
        if ($this->ExercicesChapitre->removeElement($exercicesChapitre)) {
            // set the owning side to null (unless already changed)
            if ($exercicesChapitre->getChapitre() === $this) {
                $exercicesChapitre->setChapitre(null);
            }
        }

        return $this;
    }
}
