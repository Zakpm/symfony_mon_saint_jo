<?php

namespace App\Controller\Admin\Category;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{
    #[Route('/admin/category', name: 'admin.category.index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('pages/admin/category/index.html.twig', compact('categories'));
    }

    #[Route('/admin/category/create', name: 'admin.category.create', methods: ['GET', 'POST'])]
    public function create(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category;
        $form = $this->createForm(CategoryFormType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $categoryRepository->save($category, true);
            $this->addFlash("success", "La catégorie a été ajoutée avec succès.");
            return $this->redirectToRoute("admin.category.index");
        }
        return $this->render('pages/admin/category/create.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/admin/category/{id<[0-9]+>}/edit', name: 'admin.category.edit', methods: ['GET', 'POST'])]
    public function edit(Category $category, Request $request, CategoryRepository $categoryRepository) : Response
    {
        $form = $this->createForm(CategoryFormType::class, $category);

        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid()) {

            $categoryRepository->save($category, true);

            $this->addFlash("success", "Cette catégorie a été modifiée.");
            return $this->redirectToRoute('admin.category.index');
        }

        return $this->render('pages/admin/category/edit.html.twig', [
            "form" => $form->createView(),
            "category" => $category
        ]);
        
    }  

    #[Route('/admin/category/{id<[0-9]+>}/delete', name: 'admin.category.delete', methods: ['POST'])]
    public function delete(Category $category, Request $request, CategoryRepository $categoryRepository) : Response
    {
        if ($this->isCsrfTokenValid('category_' . $category->getId(), $request->request->get('_csrf_token') )) {

            $categoryRepository->remove($category, true);
            $this->addFlash("success", "La catégorie " . $category->getName() . " a été suprimée.");
        } 

        return $this->redirectToRoute('admin.category.index');
    }

}
