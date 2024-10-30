<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Advert;
use App\Entity\User;
use App\Form\SearchDataType;
use App\Repository\AdvertRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use League\Glide\Filesystem\FileNotFoundException;
use League\Glide\Responses\SymfonyResponseFactory;
use League\Glide\Server;
use League\Glide\Signatures\SignatureException;
use League\Glide\Signatures\SignatureFactory;
use League\Glide\ServerFactory;

class HomeController extends AbstractController
{
	#[Route('/', name: 'home')]
	public function index(AdvertRepository $advertRepository, Request $request): Response
	{
//		$data = new SearchData();
//		$form = $this->createForm(SearchDataType::class, $data);
//		$form->handleRequest($request);
//
//		$adverts = $advertRepository->findSearch($data);
//		$page = $request->query->getInt('page', 1);
//		$adverts = $advertRepository->paginateAdverts($page, $adverts);

//		return $this->render('home/index.html.twig', [
//			'adverts' => $adverts,
//			'form' => $form
//  		]);
		return $this->render('home/index.html.twig');
	}
	
	#[Route('/annonce/{id}', name: 'app_advert_show', methods: ['GET'])]
	public function show(Advert $advert): Response
	{
		return $this->render('advert/show.html.twig', [
			'advert' => $advert,
			'edit' => false
		]);
	}
}
