<?php

namespace App\Controller;

use App\Controller\Image\SymfonyResponseFactory;
use League\Glide\ServerFactory;
use League\Glide\Signatures\SignatureException;
use League\Glide\Signatures\SignatureFactory;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ImageController extends AbstractController
{
	private readonly string $cachePath;
	private readonly string $resizeKey;
	private readonly string $publicPath;
	
	public function __construct(ParameterBagInterface $parameterBag)
	{
		$projectDir = $parameterBag->get('kernel.project_dir');
		$resizeKey = $parameterBag->get('image_resize_key');
		if (!is_string($projectDir)) {
			throw new \RuntimeException('Parameter kernel.project_dir is not a string');
		}
		if (!is_string($resizeKey)) {
			throw new \RuntimeException('Parameter image_resize_key is not a string');
		}
		$this->cachePath = $projectDir.'/var/images';
		$this->publicPath = $projectDir.'/public/img/adverts';
		$this->resizeKey = $resizeKey;
	}
	
	#[Route(path: '/media/resize/{width}/{height}/{path}', name: 'image_resizer', requirements: ['width' => '\d+', 'height' => '\d+', 'path' => '.+'])]
	public function image(int $width, int $height, string $path, Request $request): Response
	{
		$server = ServerFactory::create([
			                                'source' => $this->publicPath,
			                                'cache' => $this->cachePath,
			                                'driver' => 'imagick',
			                                'response' => new SymfonyResponseFactory(),
			                                'defaults' => [
				                                'q' => 75,
				                                'fm' => 'jpg',
				                                'fit' => 'crop',
			                                ],
		                                ]);
		[$url] = explode('?', $request->getRequestUri());
		
		try {
			SignatureFactory::create($this->resizeKey)->validateRequest($url, ['s' => $request->get('s')]);
			
			return $server->getImageResponse($path, ['w' => $width, 'h' => $height, 'fit' => 'crop']);
		} catch (SignatureException $e) {
			throw new HttpException(403, 'Signature invalide');
		}
	}
	
	#[Route(path: '/media/convert/{path}', name: 'image_jpg', requirements: ['path' => '.+'])]
	public function convert(string $path, Request $request): Response
	{
		$server = ServerFactory::create([
			                                'source' => $this->publicPath,
			                                'cache' => $this->cachePath,
			                                'driver' => 'imagick',
			                                'response' => new SymfonyResponseFactory(),
			                                'defaults' => [
				                                'q' => 75,
				                                'fm' => 'jpg',
				                                'fit' => 'crop',
			                                ],
		                                ]);
		[$url] = explode('?', $request->getRequestUri());
		try {
			SignatureFactory::create($this->resizeKey)->validateRequest($url, ['s' => $request->get('s')]);
			
			return $server->getImageResponse($path, ['fm' => 'jpg']);
		} catch (SignatureException) {
			throw new HttpException(403, 'Signature invalide');
		}
	}
}