<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]

    public function index(): RedirectResponse
    {
        return $this->redirectToRoute('app_users_list');
    }
}
