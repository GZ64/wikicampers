<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Entity\User;
use App\Form\AdvertType;
use App\Repository\AdvertRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Intl\Locales;

#[Route('/admin/annonce')]
class AdvertController extends AbstractController
{
    #[Route('/', name: 'admin_advert_index', methods: ['GET'])]
    public function index(AdvertRepository $advertRepository): Response
    {
		$user = $this->getUser();
		$roles = $user->getRoles();
	    if (in_array("ROLE_ADMIN", $roles)) {
		    return $this->render('admin/index.html.twig', [
			    'adverts' => $advertRepository->findAll(),
		    ]);
	    } elseif (in_array("ROLE_PROPRIETAIRE", $roles)) {
		    return $this->render('advert/index.html.twig', [
			    'advert' => $advertRepository->findOneBy(["idUser" => $this->getUser()->getID()])
		    ]);
	    } else {
		    return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
	    }
    }

    #[Route('/creation', name: 'admin_advert_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $advert = new Advert();
        $form = $this->createForm(AdvertType::class, $advert);
        $form->handleRequest($request);
	    

        if ($form->isSubmitted() && $form->isValid()) {
			
	        $idUser = $this->getUser()->getId();
	        $advert->setUpdatedAt(new \DateTimeImmutable());
	        $advert->setCreatedAt(new \DateTimeImmutable());
	        $advert->setIdUser($idUser);
            $entityManager->persist($advert);
            $entityManager->flush();

            return $this->redirectToRoute('admin_advert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('advert/new.html.twig', [
            'advert' => $advert,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_advert_show', methods: ['GET'])]
    public function show(Advert $advert): Response
    {
        return $this->render('advert/show.html.twig', [
            'advert' => $advert,
	        'edit' => true
        ]);
    }

    #[Route('/{id}/edition', name: 'admin_advert_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Advert $advert, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdvertType::class, $advert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_advert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('advert/edit.html.twig', [
            'advert' => $advert,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_advert_delete', methods: ['POST'])]
    public function delete(Request $request, Advert $advert, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$advert->getId(), $request->request->get('_token'))) {
			$entityManager->remove($advert);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_advert_index', [], Response::HTTP_SEE_OTHER);
    }
}
