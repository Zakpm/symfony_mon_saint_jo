<?php

namespace App\Controller\Admin\Comment;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    #[Route('/admin/comment', name: 'admin.comment.index')]
    public function index(CommentRepository $commentRepository): Response
    {
        $comments = $commentRepository->findAll();

        return $this->render('pages/admin/comment/index.html.twig', [
            'comments' => $comments,
        ]);
    }

    #[Route('/admin/comment/{id<[0-9]+>}/show', name: 'admin.comment.show')]
    public function show(Comment $comment): Response
    {

        return $this->render('pages/admin/comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    #[Route('/admin/comment/{id<[0-9]+>}/delete', name: 'admin.comment.delete', methods:['POST'])]
    public function delete(Comment $comment, Request $request, CommentRepository $commentRepository): Response
    {

        if ($this->isCsrfTokenValid('comment_' . $comment->getId(), $request->request->get('_csrf_token') )) {

            $commentRepository->remove($comment, true);
            $this->addFlash("success", "Le commentaire a été suprimé.");
        } 

        return $this->redirectToRoute('admin.comment.index');
    }
}
