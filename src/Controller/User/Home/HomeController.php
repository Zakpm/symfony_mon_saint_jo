<?php

namespace App\Controller\User\Home;

use App\Entity\Comment;
use App\Entity\Post;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/user/home', name: 'user.home.index')]
    public function index(): Response
    {
       
        
        $user = $this->getUser();
        $user_comments = $user->getComments();

        return $this->render('pages/user/home/index.html.twig', [
            'user_comments' => $user_comments,
        ]);
    }
}
