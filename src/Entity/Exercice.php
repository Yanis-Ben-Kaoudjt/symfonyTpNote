<?php

namespace App\Entity;

use App\Repository\ExerciceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciceRepository::class)]
class Exercice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $consigne = null;

    #[ORM\ManyToOne(inversedBy: 'ExercicesChapitre')]
    private ?Chapitre $chapitre = null;

    /**
     * @var Collection<int, Commentaire>
     */
    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'exercice')]
    private Collection $CommentairesExercice;

    public function __construct()
    {
        $this->CommentairesExercice = new ArrayCollection();
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

    public function getConsigne(): ?string
    {
        return $this->consigne;
    }

    public function setConsigne(string $consigne): static
    {
        $this->consigne = $consigne;

        return $this;
    }

    public function getChapitre(): ?Chapitre
    {
        return $this->chapitre;
    }

    public function setChapitre(?Chapitre $chapitre): static
    {
        $this->chapitre = $chapitre;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentairesExercice(): Collection
    {
        return $this->CommentairesExercice;
    }

    public function addCommentairesExercice(Commentaire $commentairesExercice): static
    {
        if (!$this->CommentairesExercice->contains($commentairesExercice)) {
            $this->CommentairesExercice->add($commentairesExercice);
            $commentairesExercice->setExercice($this);
        }

        return $this;
    }

    public function removeCommentairesExercice(Commentaire $commentairesExercice): static
    {
        if ($this->CommentairesExercice->removeElement($commentairesExercice)) {
            // set the owning side to null (unless already changed)
            if ($commentairesExercice->getExercice() === $this) {
                $commentairesExercice->setExercice(null);
            }
        }

        return $this;
    }
}
