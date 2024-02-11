<?php

namespace App\Controller\Admin\City;

use App\Entity\City;
use App\Form\CityFormType;
use App\Repository\CityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CityController extends AbstractController
{
    #[Route('/admin/city/list', name: 'admin.city.index')]
    public function index(CityRepository $cityRepository): Response
    {
        $cities = $cityRepository->findAll();
        return $this->render('pages/admin/city/index.html.twig', compact('cities'));
    }

    #[Route('/admin/city/create', name: 'admin.city.create', methods: ['GET', 'POST'])]
    public function create(Request $request, CityRepository $cityRepository): Response
    {
        $city = new City();
        $form = $this->createForm(CityFormType::class, $city);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $cityRepository->save($city, true);
            $this->addFlash("success", "Une nouvelle ville a été ajoutée.");
            return $this->redirectToRoute("admin.city.index");
        }

        return $this->render('pages/admin/city/create.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/admin/city/{id<[0-9]+>}/edit', name: 'admin.city.edit', methods: ['GET', 'POST'])]
    public function edit(City $city, Request $request, CityRepository $cityRepository): Response
    {
        $form = $this->createForm(CityFormType::class, $city);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $cityRepository->save($city, true);
            $this->addFlash("success", "La ville a été modifée.");
            return $this->redirectToRoute("admin.city.index");
        }

        return $this->render('pages/admin/city/edit.html.twig', [
            "form" => $form->createView(),
            "city" => $city
        ]);
    }

    #[Route('/admin/city/{id<[0-9]+>}/delete', name: 'admin.city.delete', methods: ['POST'])]
    public function delete(City $city, Request $request, CityRepository $cityRepository): Response
    {
        if ($this->isCsrfTokenValid('city_' . $city->getId(), $request->request->get('_csrf_token'))) {
            
            $cityRepository->remove($city, true);
            $this->addFlash("success", "La ville " . $city->getName() . " a été suprimée.");
        }

        return $this->redirectToRoute("admin.city.index");
    }


}
