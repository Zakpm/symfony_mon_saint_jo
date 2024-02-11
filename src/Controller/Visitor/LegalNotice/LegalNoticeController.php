<?php

namespace App\Controller\Visitor\LegalNotice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalNoticeController extends AbstractController
{
    #[Route('/visitor/legal-notice', name: 'visitor.legal_notice.index')]
    public function index(): Response
    {
        return $this->render('pages/visitor/legal_notice/index.html.twig');
    }
}
