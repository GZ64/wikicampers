<?php

namespace App\Entity;

use App\Repository\SearchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SearchRepository::class)]
class Search
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Advert::class)]
    private Collection $idAdvert;

    #[ORM\ManyToMany(targetEntity: User::class)]
    private Collection $idUser;

    public function __construct()
    {
        $this->idAdvert = new ArrayCollection();
        $this->idUser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Advert>
     */
    public function getIdAdvert(): Collection
    {
        return $this->idAdvert;
    }

    public function addIdAdvert(Advert $idAdvert): static
    {
        if (!$this->idAdvert->contains($idAdvert)) {
            $this->idAdvert->add($idAdvert);
        }

        return $this;
    }

    public function removeIdAdvert(Advert $idAdvert): static
    {
        $this->idAdvert->removeElement($idAdvert);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getIdUser(): Collection
    {
        return $this->idUser;
    }

    public function addIdUser(User $idUser): static
    {
        if (!$this->idUser->contains($idUser)) {
            $this->idUser->add($idUser);
        }

        return $this;
    }

    public function removeIdUser(User $idUser): static
    {
        $this->idUser->removeElement($idUser);

        return $this;
    }
}
