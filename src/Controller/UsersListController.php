<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UsersListController extends AbstractController
{
    #[Route('/users', name: 'app_users_list')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $allUsers = $doctrine->getRepository(User::class)->findAll();
        $activeUser = $doctrine->getRepository(User::class)->find($this->getUser()->getId());
        return $this->render('users_list/index.html.twig', [
            'controller_name' => 'UsersListController',
            'users' => $allUsers,
            'activeUser' => $activeUser
        ]);
    }

    #[Route('/users/update', name: 'users_update', methods: ['POST'])]
    public function updateUsersStatus(Request $request, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage, SessionInterface $session): JsonResponse
    {

        $data = json_decode($request->getContent(), true);
        $userIds = $data['ids'];
        $status = $data['status'];
        $users = $entityManager->getRepository(User::class)->findBy(['id' => $userIds]);
        foreach ($users as $user) {
            $user->setStatus($status);
            if ($status === 'deleted') {
                if($this->getUser() == $user){
                    $session->invalidate();
                    $tokenStorage->setToken(null);
                }
                $entityManager->remove($user);
                $entityManager->flush();
            }
        }
        $entityManager->flush();

        return new JsonResponse('ok');
    }
}
