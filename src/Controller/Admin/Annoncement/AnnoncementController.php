<?php

namespace App\Controller\Admin\Annoncement;

use App\Entity\Annoncement;
use App\Form\AnnoncementFormType;
use App\Repository\AnnoncementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnnoncementController extends AbstractController
{
    #[Route('/admin/annoncement', name: 'admin.annoncement.index')]
    public function index(AnnoncementRepository $annoncementRepository): Response
    {
        $annoncements = $annoncementRepository->findAll();
        return $this->render('pages/admin/annoncement/index.html.twig', [
            'annoncements' => $annoncements
        ]);
    }

    #[Route('/admin/annoncement/create', name: 'admin.annoncement.create')]
    public function create(Request $request, AnnoncementRepository $annoncementRepository): Response
    {

        $annoncement = new Annoncement();
        $form = $this->createForm(AnnoncementFormType::class, $annoncement);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $annoncementRepository->save($annoncement, true);
            $this->addFlash("success", "Une nouvelle annonce a été ajoutée.");
            return $this->redirectToRoute("admin.annoncement.index");
        }

        return $this->render('pages/admin/annoncement/create.html.twig', [
            "form" => $form->createView()
        ]);
    }

     /**
     * Cette méthode permet de lire l'annonce 
     * dont l'identifiant est passé en paramètre à la route
     */
    #[Route('/admin/annoncement/{id<[0-9]+>}/show', name: 'admin.annoncement.show')]
    public function show(Annoncement $annoncement) : Response
    {
        
        return $this->render('pages/admin/annoncement/show.html.twig', compact('annoncement'));
    }

    #[Route('/admin/annoncement/{id<[0-9]+>}/publish', name: 'admin.annoncement.publish')]
    public function publish(
        Annoncement $annoncement, 
        AnnoncementRepository $annoncementRepository, 
        ) : Response
    {

        if ($annoncement->isIsPublished() == false) {

            $annoncement->setIsPublished(true);
            $annoncement->setPublishedAt(new \DateTimeImmutable('now'));
            $annoncementRepository->save($annoncement, true);
            $this->addFlash("success", "Votre annonce vient d'être publiée.");
        }
        else {

            $annoncement->setIsPublished(false);
            $annoncement->setPublishedAt(null);
            $annoncementRepository->save($annoncement, true);
            $this->addFlash("success", "Votre annonce vient d'être retirée de la liste de publication.");
        }

        return $this->redirectToRoute("admin.annoncement.index");
    }

    #[Route('/admin/annoncement/{id<\d+>}/edit', name: 'admin.annoncement.edit')]
    public function edit(
        Annoncement $annoncement, 
        Request $request, 
        AnnoncementRepository $annoncementRepository
        ) : Response
    {
        $form = $this->createForm(AnnoncementFormType::class, $annoncement);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $annoncementRepository->save($annoncement, true);
            $this->addFlash("success", "L'annonce " . $annoncement->getTitre() . " a été modifiée !");
            return $this->redirectToRoute("admin.annoncement.index");
        }

        return $this->render("pages/admin/annoncement/edit.html.twig", [
            "form" => $form->createView(),
            "annoncement" => $annoncement,
        ]);
    }

    #[Route('/admin/annoncement/{id<\d+>}/delete', name: 'admin.annoncement.delete')]
    public function delete(Annoncement $annoncement, Request $request, AnnoncementRepository $annoncementRepository) : Response
    {
        if ( $this->isCsrfTokenValid('annoncement_' . $annoncement->getId(), $request->request->get('_csrf_token')) ) 
        {
            $annoncementRepository->remove($annoncement, true);
            $this->addFlash('success', "L'annonce " . $annoncement->getTitre() ." a été supprimée.");
        }

        return $this->redirectToRoute('admin.annoncement.index');
    }
}
