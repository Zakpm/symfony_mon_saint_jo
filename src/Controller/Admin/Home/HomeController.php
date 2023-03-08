<?php

namespace App\Controller\Admin\Home;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\CityRepository;
use App\Repository\CommentRepository;
use App\Repository\ContactRepository;
use App\Repository\PostRepository;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/admin/home', name: 'admin.home.index')]
    public function index(
        PostRepository $postRepository, 
        CategoryRepository $categoryRepository, 
        TagRepository $tagRepository,
        CommentRepository $commentRepository,
        ContactRepository $contactRepository,
        CityRepository $cityRepository,
        UserRepository $userRepository,
        ): Response
    {
        $posts = $postRepository->findAll();
        $categories = $categoryRepository->findAll();
        $tags = $tagRepository->findAll();
        $comments = $commentRepository->findAll();
        $cities = $cityRepository->findAll();
        $contacts = $contactRepository->findAll();
        $users = $userRepository->findAll();


        return $this->render('pages/admin/home/index.html.twig', compact('posts', 'categories', 'tags', 'comments', 'contacts', 'cities', 'users') );
    }
   
}
