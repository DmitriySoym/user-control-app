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
        $allUsersFltred = [];
        $allUsers = $doctrine->getRepository(User::class)->findAll();
        foreach ($allUsers as $value) {
            print_r ($value->getEmail());
        }

        return $this->render('users_list/index.html.twig', [
            'controller_name' => 'UsersListController',
            'users' => $allUsers
        ]);
    }
}
