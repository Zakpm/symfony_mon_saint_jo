<?php

namespace App\Controller\Admin\Tag;

use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    #[Route('/admin/tag/list', name: 'admin.tag.index')]
    public function index(TagRepository $tagRepository): Response
    {
        return $this->render('pages/admin/tag/index.html.twig', [
            "tag" => $tagRepository->findAll()
        ]);
    }
}
