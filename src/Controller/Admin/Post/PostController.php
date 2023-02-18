<?php

namespace App\Controller\Admin\Post;

use App\Entity\Post;
use App\Form\PostFormType;
use App\Repository\CategoryRepository;
use App\Repository\CityRepository;
use App\Repository\PostRepository;
use App\Repository\TagRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PostController extends AbstractController
{
    #[Route('/admin/post/list', name: 'admin.post.index')]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findBy([], ['createdAt' => 'DESC']);
        return $this->render('pages/admin/post/index.html.twig', compact('posts'));
    }

    #[Route('/admin/post/create', name: 'admin.post.create')]
    public function create(Request $request,
     PostRepository $postRepository,
     CategoryRepository $categoryRepository,
     CityRepository $cityRepository,
     TagRepository $tagRepository,

     ): Response
    {

        if ( ! $categoryRepository->findAll()) {
             
            $this->addFlash("warning", "Vous devez créer au moins une catégorie avant de rédiger des articles.");
            return $this->redirectToRoute("admin.category.index");
        }

        if ( ! $cityRepository->findAll()) {
             
            $this->addFlash("warning", "Vous devez créer au moins une ville avant de rédiger des articles.");
            return $this->redirectToRoute("admin.city.index");
        }

        $post = new Post();
        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid()) {

            $post->setUser($this->getUser());
            $postRepository->save($post, true);
            $this->addFlash("success", "Votre article a été sauvegardé !");
            return $this->redirectToRoute("admin.post.index");
        }

        return $this->render('pages/admin/post/create.html.twig', [
            "form" => $form->createView(),
            "tags" => $tagRepository->findAll(),
            "cities" => $cityRepository->findAll()
        ]); 
    }

    /**
     * Cette méthode permet de lire l'article 
     * dont l'identifiant est passé en paramètre à la route
     */
    #[Route('/admin/post/{id<[0-9]+>}/show', name: 'admin.post.show')]
    public function show(Post $post) : Response
    {
        
        return $this->render('pages/admin/post/show.html.twig', compact('post'));
    }

    #[Route('/admin/post/{id<[0-9]+>}/publish', name: 'admin.post.publish')]
    public function publish(
        Post $post, 
        PostRepository $postRepository, 
        CityRepository $cityRepository,
        ) : Response
    {

        if ($post->isIsPublished() == false) {

            $post->setIsPublished(true);
            $post->setPublishedAt(new \DateTimeImmutable('now'));
            $postRepository->save($post, true);
            $this->addFlash("success", "Votre article vient d'être publié.");
        }
        else {

            $post->setIsPublished(false);
            $post->setPublishedAt(null);
            $postRepository->save($post, true);
            $this->addFlash("success", "Votre article vient d'être retiré de la liste de publication.");
        }

        return $this->redirectToRoute("admin.post.index");
    }

    #[Route('/admin/post/{id<[0-9]+>}/feature', name: 'admin.post.feature')]
    public function feature(
        Post $post, 
        PostRepository $postRepository, 
        CityRepository $cityRepository,
        ) : Response
    {

        if ($post->isIsFeatured() == false) {

            $post->setIsFeatured(true);
            // $post->setPublishedAt(new \DateTimeImmutable('now'));
            $postRepository->save($post, true);
            $this->addFlash("success", "Votre article vient d'être publié à la une.");
        }
        else {

            $post->setIsFeatured(false);
            // $post->setPublishedAt(null);
            $postRepository->save($post, true);
            $this->addFlash("success", "Votre article vient d'être retiré de la liste de publication à la une.");
        }

        return $this->redirectToRoute("admin.post.index");
    }

    #[Route('/admin/post/{id<\d+>}/edit', name: 'admin.post.edit')]
    public function edit(
        Post $post, 
        Request $request, 
        PostRepository $postRepository,
        CategoryRepository $categoryRepository,
        CityRepository $cityRepository,
        TagRepository $tagRepository,
        ) : Response
    {
        if ( ! $categoryRepository->findAll()) {
             
            $this->addFlash("warning", "Vous devez créer au moins une catégorie avant de rédiger des articles.");
            return $this->redirectToRoute("admin.category.index");
        }

        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $post->setUser($this->getUser());
            $postRepository->save($post, true);
            $this->addFlash("success", "L'article " . $post->getTitle() . " a été modifié !");
            return $this->redirectToRoute("admin.post.index");
        }

        return $this->render("pages/admin/post/edit.html.twig", [
            "form" => $form->createView(),
            "post" => $post,
            "tags" => $tagRepository->findAll(),
        ]);
    }


    #[Route('/admin/post/{id<\d+>}/delete', name: 'admin.post.delete')]
    public function delete(Post $post, Request $request, PostRepository $postRepository) : Response
    {
        if ( $this->isCsrfTokenValid('post_' . $post->getId(), $request->request->get('_csrf_token')) ) 
        {
            $postRepository->remove($post, true);
            $this->addFlash('success', "L'article " . $post->getTitle() ." a été supprimé.");
        }

        return $this->redirectToRoute('admin.post.index');
    }

}
