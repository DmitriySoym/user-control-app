<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UsersListController extends AbstractController
{
    #[Route('/users', name: 'app_users_list')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $allUsers = $doctrine->getRepository(User::class)->findAll();

        return $this->render('users_list/index.html.twig', [
            'controller_name' => 'UsersListController',
            'users' => $allUsers
        ]);
    }
}
