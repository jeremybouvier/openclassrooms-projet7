<?php

namespace App\EventListener;

use App\Entity\Customer;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class CustomerListener implements EventSubscriber
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * CustomerListener constructor.
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return array|string[]
     */
    public function getSubscribedEvents()
    {
        return ['prePersist','preUpdate'];
    }

    /**
     * Demande d'encodage du mot de passe lors d'un enregistrement en base de donnée
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $customer = $eventArgs->getEntity();
        if (!$customer instanceof Customer) {
            return;
        }

        $customer->setUser($this->getUser());
    }

    /**
     * recupération du client depuis le token
     * @return UserInterface|null
     */
    private function getUser(): ?UserInterface
    {
        if (!$token = $this->tokenStorage->getToken()) {
            return null;
        }

        $user = $token->getUser();
        return $user instanceof UserInterface ? $user : null;
    }

}