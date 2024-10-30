<?php

namespace App\Entity;

use App\Repository\AdvertRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AdvertRepository::class)]
class Advert
{
	#[ORM\Id]
         	#[ORM\GeneratedValue]
         	#[ORM\Column]
         	private ?int $id = null;
	
	#[ORM\Column(length: 255)]
         	private ?string $title = null;
	
	#[ORM\Column(length: 255)]
         	private ?string $description = null;
	
	#[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
         	private ?string $pricePerDay = null;
	
	#[ORM\Column(nullable: true)]
         	private ?\DateTimeImmutable $availability = null;
	
	#[ORM\Column(length: 255)]
         	private ?string $city = null;
	
	#[ORM\Column(nullable: true)]
         	private ?\DateTimeImmutable $createdAt = null;
	
	#[ORM\Column(nullable: true)]
         	private ?\DateTimeImmutable $updatedAt = null;
	
	#[ORM\OneToOne(cascade: ['persist', 'remove'])]
         	#[ORM\Column]
         	private ?int $idUser = null;
	
	#[ORM\OneToMany(targetEntity: Thumbnail::class, mappedBy: 'idAdvert', cascade: ['persist', 'remove'])]
         	private Collection $thumbnails;
	
	
	#[ORM\ManyToMany(targetEntity: Equipment::class, cascade: ['persist', 'remove'], fetch: "EXTRA_LAZY", orphanRemoval: true)]
         	private Collection $equipment;

    #[ORM\Column(nullable: true)]
    private ?int $campingCarSize = null;
	
	public function __construct()
         	{
         		$this->thumbnails = new ArrayCollection();
         		$this->equipment = new ArrayCollection();
         	}
	
	public function getId(): ?int
         	{
         		return $this->id;
         	}
	
	public function getTitle(): ?string
         	{
         		return $this->title;
         	}
	
	public function setTitle(string $title): static
         	{
         		$this->title = $title;
         		
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
	
	public function getPricePerDay(): ?string
         	{
         		return $this->pricePerDay;
         	}
	
	public function setPricePerDay(?string $pricePerDay): static
         	{
         		$this->pricePerDay = $pricePerDay;
         		
         		return $this;
         	}
	
	public function getAvailability(): ?\DateTimeImmutable
         	{
         		return $this->availability;
         	}
	
	public function setAvailability(?\DateTimeImmutable $availability): static
         	{
         		$this->availability = $availability;
         		
         		return $this;
         	}
	
	public function getCity(): ?string
         	{
         		return $this->city;
         	}
	
	public function setCity(string $city): static
         	{
         		$this->city = $city;
         		
         		return $this;
         	}
	
	public function getCreatedAt(): ?\DateTimeImmutable
         	{
         		return $this->createdAt;
         	}
	
	public function setCreatedAt(?\DateTimeImmutable $createdAt): static
         	{
         		$this->createdAt = $createdAt;
         		
         		return $this;
         	}
	
	public function getUpdatedAt(): ?\DateTimeImmutable
         	{
         		return $this->updatedAt;
         	}
	
	public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
         	{
         		$this->updatedAt = $updatedAt;
         		
         		return $this;
         	}
	
	public function getIdUser(): ?int
         	{
         		return $this->idUser;
         	}
	
	public function setIdUser(int $idUser): static
         	{
         		$this->idUser = $idUser;
         		
         		return $this;
         	}
	
	/**
	 * @return Collection<int, Thumbnail>
	 */
	public function getThumbnails(): Collection
         	{
         		return $this->thumbnails;
         	}
	
	public function addThumbnail(Thumbnail $thumbnail): static
         	{
         		if (!$this->thumbnails->contains($thumbnail)) {
         			$this->thumbnails->add($thumbnail);
         			$thumbnail->setIdAdvert($this);
         		}
         		
         		return $this;
         	}
	
	public function removeThumbnail(Thumbnail $thumbnail): static
         	{
         		if ($this->thumbnails->removeElement($thumbnail)) {
         			// set the owning side to null (unless already changed)
         			if ($thumbnail->getIdAdvert() === $this) {
         				$thumbnail->setIdAdvert(null);
         			}
         		}
         		
         		return $this;
         	}
	
	/**
	 * @return Collection<int, Equipment>
	 */
	public function getEquipment(): Collection
         	{
         		return $this->equipment;
         	}
	
	public function addEquipment(Equipment $equipment): static
         	{
         		if (!$this->equipment->contains($equipment)) {
         			$this->equipment->add($equipment);
         		}
         		
         		return $this;
         	}
	
	public function removeEquipment(Equipment $equipment): static
         	{
         		$this->equipment->removeElement($equipment);
         		
         		return $this;
         	}

    public function getCampingCarSize(): ?int
    {
        return $this->campingCarSize;
    }

    public function setCampingCarSize(?int $campingCarSize): static
    {
        $this->campingCarSize = $campingCarSize;

        return $this;
    }
}