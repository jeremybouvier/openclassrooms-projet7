<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HashPasswordListener implements EventSubscriber
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
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
        $user = $eventArgs->getEntity();
        if (!$user instanceof User) {
            return;
        }

        $user->setPassword($this->encodedPassword($user));
    }

    /**
     * Demande d'encodage du mot de passe lors d'une mise à jour en base de donnée
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $user = $eventArgs->getEntity();
        if (!$user instanceof User) {
            return;
        }

        if (!$user->getPlainPassword()) {
            return;
        }

        $user->setPassword($this->encodedPassword($user));
    }

    /**
     * Encodage du mot de passe
     * @param $user
     * @return string
     */
    private function encodedPassword($user)
    {
        return $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
    }
}
