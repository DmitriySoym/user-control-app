<?php

namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;

class SignInListener
{
    protected EntityManagerInterface $em;
    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    #[AsEventListener(event: 'security.authentication.success')]
    public function onSecurityAuthenticationSuccess(AuthenticationSuccessEvent $event) : void
    {
        $user = $event->getAuthenticationToken()->getUser();
        $user->setLastLoginDate(new \DateTimeImmutable());
        $this->em->persist($user);
        $this->em->flush();
    }
}
