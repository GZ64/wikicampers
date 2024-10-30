<?php

namespace App\Entity;

use App\Repository\ThumbnailRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ThumbnailRepository::class)]
#[Vich\Uploadable()]
class Thumbnail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $path = null;
	
	#[ORM\ManyToOne(inversedBy: 'thumbnails')]
	private ?Advert $idAdvert = null;
	
	#[Vich\UploadableField(mapping: 'adverts', fileNameProperty: 'path')]
	#[Assert\Image()]
	private ?File $thumbnailFile = null;
	
	public function getThumbnailFile(): ?File {
		return $this->thumbnailFile;
	}
	
	public function setThumbnailFile(?File $thumbnailFile): static {
		$this->thumbnailFile = $thumbnailFile;
		return $this;
	}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path = null): static
    {
        $this->path = $path;

        return $this;
    }

    public function getIdAdvert(): ?Advert
    {
        return $this->idAdvert;
    }

    public function setIdAdvert(?Advert $idAdvert): static
    {
        $this->idAdvert = $idAdvert;

        return $this;
    }
}
