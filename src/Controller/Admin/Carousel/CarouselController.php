<?php

namespace App\Controller\Admin\Carousel;

use App\Entity\Carousel;
use App\Form\CarouselFormType;
use App\Repository\CarouselRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarouselController extends AbstractController
{
    #[Route('/admin/carousel', name: 'admin.carousel.index')]
    public function index(CarouselRepository $carouselRepository): Response
    {
        $carousels = $carouselRepository->findAll();
        return $this->render('pages/admin/carousel/index.html.twig', [
            'carousels' => $carousels,
        ]);
    }


    #[Route('/admin/carousel/create', name: 'admin.carousel.create')]
    public function create(Request $request, CarouselRepository $carouselRepository): Response
    {

        $carousel = new Carousel();
        $form = $this->createForm(CarouselFormType::class, $carousel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $carouselRepository->save($carousel, true);
            $this->addFlash("success", "Une image a été ajoutée.");
            return $this->redirectToRoute("admin.carousel.index");
        }

        return $this->render('pages/admin/carousel/create.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * Cette méthode permet de lire la pub 
     * dont l'identifiant est passé en paramètre à la route
     */
    #[Route('/admin/carousel/{id<[0-9]+>}/show', name: 'admin.carousel.show')]
    public function show(Carousel $carousel) : Response
    {
        
        return $this->render('pages/admin/carousel/show.html.twig', compact('carousel'));
    }

    #[Route('/admin/carousel/{id<[0-9]+>}/publish', name: 'admin.carousel.publish')]
    public function publish(
        Carousel $carousel, 
        CarouselRepository $carouselRepository, 
        ) : Response
    {

        if ($carousel->isIsPublished() == false) {

            $carousel->setIsPublished(true);
            $carousel->setPublishedAt(new \DateTimeImmutable('now'));
            $carouselRepository->save($carousel, true);
            $this->addFlash("success", "Votre image vient d'être publiée.");
        }
        else {

            $carousel->setIsPublished(false);
            $carousel->setPublishedAt(null);
            $carouselRepository->save($carousel, true);
            $this->addFlash("success", "Votre image vient d'être retirée de la liste de publication.");
        }

        return $this->redirectToRoute("admin.carousel.index");
    }

    #[Route('/admin/carousel/{id<\d+>}/edit', name: 'admin.carousel.edit')]
    public function edit(
        Carousel $carousel, 
        Request $request, 
        CarouselRepository $carouselRepository
        ) : Response
    {
        $form = $this->createForm(CarouselFormType::class, $carousel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $carouselRepository->save($carousel, true);
            $this->addFlash("success", "L'image " . $carousel->getTitre() . " a été modifiée !");
            return $this->redirectToRoute("admin.carousel.index");
        }

        return $this->render("pages/admin/carousel/edit.html.twig", [
            "form" => $form->createView(),
            "carousel" => $carousel,
        ]);
    }

    #[Route('/admin/carousel/{id<\d+>}/delete', name: 'admin.carousel.delete')]
    public function delete(Carousel $carousel, Request $request, CarouselRepository $carouselRepository) : Response
    {
        if ( $this->isCsrfTokenValid('carousel_' . $carousel->getId(), $request->request->get('_csrf_token')) ) 
        {
            $carouselRepository->remove($carousel, true);
            $this->addFlash('success', "L'image " . $carousel->getTitre() ." a été supprimée.");
        }

        return $this->redirectToRoute('admin.carousel.index');
    }
}
