<?php

namespace App\Controller\Admin\Advertising;

use App\Entity\Advertising;
use App\Form\AdvertisingFormType;
use App\Repository\AdvertisingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdvertisingController extends AbstractController
{
    #[Route('/admin/advertising', name: 'admin.advertising.index')]
    public function index(AdvertisingRepository $advertisingRepository): Response
    {
        $ads = $advertisingRepository->findAll();
        return $this->render('pages/admin/advertising/index.html.twig', [
            'ads' => $ads,
        ]);
    }

    #[Route('/admin/advertising/create', name: 'admin.advertising.create')]
    public function create(Request $request, AdvertisingRepository $advertisingRepository): Response
    {

        $advertising = new Advertising();
        $form = $this->createForm(AdvertisingFormType::class, $advertising);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $advertisingRepository->save($advertising, true);
            $this->addFlash("success", "Une nouvelle pub a été ajoutée.");
            return $this->redirectToRoute("admin.advertising.index");
        }

        return $this->render('pages/admin/advertising/create.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * Cette méthode permet de lire la pub 
     * dont l'identifiant est passé en paramètre à la route
     */
    #[Route('/admin/advertising/{id<[0-9]+>}/show', name: 'admin.advertising.show')]
    public function show(Advertising $advertising) : Response
    {
        
        return $this->render('pages/admin/advertising/show.html.twig', compact('advertising'));
    }

    #[Route('/admin/advertising/{id<[0-9]+>}/publish', name: 'admin.advertising.publish')]
    public function publish(
        Advertising $advertising, 
        AdvertisingRepository $advertisingRepository, 
        ) : Response
    {

        if ($advertising->isIsPublished() == false) {

            $advertising->setIsPublished(true);
            $advertising->setPublishedAt(new \DateTimeImmutable('now'));
            $advertisingRepository->save($advertising, true);
            $this->addFlash("success", "Votre pub vient d'être publiée.");
        }
        else {

            $advertising->setIsPublished(false);
            $advertising->setPublishedAt(null);
            $advertisingRepository->save($advertising, true);
            $this->addFlash("success", "Votre pub vient d'être retirée de la liste de publication.");
        }

        return $this->redirectToRoute("admin.advertising.index");
    }


    #[Route('/admin/advertising/{id<\d+>}/edit', name: 'admin.advertising.edit')]
    public function edit(
        Advertising $advertising, 
        Request $request, 
        AdvertisingRepository $advertisingRepository
        ) : Response
    {
        $form = $this->createForm(AdvertisingFormType::class, $advertising);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $advertisingRepository->save($advertising, true);
            $this->addFlash("success", "La pub " . $advertising->getTitle() . " a été modifiée !");
            return $this->redirectToRoute("admin.advertising.index");
        }

        return $this->render("pages/admin/advertising/edit.html.twig", [
            "form" => $form->createView(),
            "advertising" => $advertising,
        ]);
    }

    #[Route('/admin/advertising/{id<\d+>}/delete', name: 'admin.advertising.delete')]
    public function delete(Advertising $advertising, Request $request, AdvertisingRepository $advertisingRepository) : Response
    {
        if ( $this->isCsrfTokenValid('advertising_' . $advertising->getId(), $request->request->get('_csrf_token')) ) 
        {
            $advertisingRepository->remove($advertising, true);
            $this->addFlash('success', "La pub " . $advertising->getTitle() ." a été supprimée.");
        }

        return $this->redirectToRoute('admin.advertising.index');
    }

}
