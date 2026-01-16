<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/', name: 'app_contact_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('contact/index.html.twig');
    }
}
