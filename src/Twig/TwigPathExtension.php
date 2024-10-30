<?php

namespace App\Twig;

use App\Controller\Image\ImageResizer;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class TwigPathExtension extends AbstractExtension
{
	public function __construct(
		private readonly ImageResizer $imageResizer,
		private readonly UploaderHelper $helper
	) {
	}
	
	public function getFunctions(): array
	{
		return [
			new TwigFunction('uploads_path', $this->uploadsPath(...)),
			new TwigFunction('image_url', $this->imageUrl(...)),
			new TwigFunction('image_url_raw', $this->imageUrlRaw(...)),
			new TwigFunction('image', $this->imageTag(...), ['is_safe' => ['html']]),
		];
	}
	
	public function uploadsPath(string $path): string
	{
		return '/uploads/'.trim($path, '/');
	}
	
	public function imageUrl(?string $path, ?int $width = null, ?int $height = null): ?string
	{
		
		if (null === $path) {
			return null;
		}
//		if ('jpg' !== pathinfo($path, PATHINFO_EXTENSION)) {
//			return $path;
//		}
		
		return $this->imageResizer->resize($path, $width, $height);
	}
	
	public function imageUrlRaw(?object $entity): string
	{
		if (null === $entity || $entity) {
			return '';
		}
		
		return $this->helper->asset($entity) ?: '';
	}
	
	public function imageTag(?object $entity, ?int $width = null, ?int $height = null): ?string
	{
		$url = $this->imageUrl($entity, $width, $height);
		if (null !== $url) {
			return "<img src=\"{$url}\" width=\"{$width}\" height=\"{$height}\"/>";
		}
		
		return null;
	}
}