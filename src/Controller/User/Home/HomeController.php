<?php

namespace App\Controller\User\Home;

use App\Entity\Comment;
use App\Entity\Post;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/user/home', name: 'user.home.index')]
    public function index(CommentRepository $commentRepository): Response
    {
        $comments = $commentRepository->findAll();

        return $this->render('pages/user/home/index.html.twig', [
            'comments' => $comments,
        ]);
    }
}
