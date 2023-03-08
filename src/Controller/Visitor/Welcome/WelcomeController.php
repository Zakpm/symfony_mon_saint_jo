<?php

namespace App\Controller\Visitor\Welcome;


use App\Entity\City;
use App\Entity\Post;
use App\Entity\Comment;
use App\Repository\AdvertisingRepository;
use App\Repository\TagRepository;
use App\Repository\CityRepository;
use App\Repository\PostRepository;
use App\Repository\CommentRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WelcomeController extends AbstractController
{
    // #[Route('/', name: 'visitor.welcome.index')]
    // public function index(): Response
    // {
    //     return $this->render('pages/visitor/welcome/index.html.twig');
    // }

    #[Route('/', name: 'visitor.welcome.index')]
    public function index(
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
        PostRepository $postRepository,
        CityRepository $cityRepository,
        PaginatorInterface $paginator,
        Request $request,
        AdvertisingRepository $advertisingRepository,
    ): Response 
    {
      
        $categories  = $categoryRepository->findAll();
        $tags        = $tagRepository->findAll();
        $cities      = $cityRepository->findAll();
        $posts       = $postRepository->findBy(['isPublished' => true, 'isFeatured' => true], ['createdAt' => 'DESC'], $limit = 3);
        $posts1      = $postRepository->findBy(['isPublished' => true, 'isFeatured' => false], ['createdAt' => 'DESC'], $limit = 6);
        $ads         = $advertisingRepository->findBy(['isPublished' => true]);
    
    return $this->render('pages/visitor/welcome/index.html.twig', compact('categories', 'tags', 'posts', 'cities', 'ads', 'posts1'));
    
    }
    
    
}
