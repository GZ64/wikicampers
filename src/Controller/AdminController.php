<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Repository\AdvertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/annonce')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'admin_advert_index')]
    public function index(AdvertRepository $advertRepository): Response
    {
	    return $this->render('admin/index.html.twig', [
		    'adverts' => $advertRepository->findAll(),
	    ]);
    }
	
	#[Route('/{id}', name: 'admin_advert_show', methods: ['GET'])]
	public function show(Advert $advert): Response
	{
		return $this->render('advert/show.html.twig', [
			'advert' => $advert,
		]);
	}
}
