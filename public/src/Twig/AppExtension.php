<?php

namespace App\Twig;

use App\Entity\Event;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    protected $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('isOwner', [$this, 'isOwner']),
        ];
    }

    public function isOwner(?User $user, Event $event)
    {
        if ($user === null) {
            return false;
        }
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }
        return $user === $event->getCreatedBy();
    }
}