<?php

namespace App\Entity;

use App\Repository\EquipmentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: EquipmentRepository::class)]
#[UniqueEntity('nameEquipment')]
class Equipment
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;
	
	#[ORM\Column(name: 'nameEquipment', length: 255, unique: true)]
	private ?string $nameEquipment = null;
	
	public function getId(): ?int
	{
		return $this->id;
	}
	
	public function getNameEquipment(): ?string
	{
		return $this->nameEquipment;
	}
	
	public function setNameEquipment(string $nameEquipment): static
	{
		$this->nameEquipment = $nameEquipment;
		
		return $this;
	}
	
	public function __toString() {
		return $this->nameEquipment;
	}
}