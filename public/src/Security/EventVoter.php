<?php

namespace App\Security;

use App\Entity\Event;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class EventVoter extends Voter
{
    const SHOW = 'show';
    const EDIT = 'edit';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::SHOW, self::EDIT])) {
            return false;
        }

        // only vote on Event  objects inside this voter
        if (!$subject instanceof Event) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // ROLE_ADMIN can do anything!
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        /** @var Event $event */
        $event = $subject;

        switch ($attribute) {
            case self::SHOW:
                return $this->canShow($event, $user);
            case self::EDIT:
                return $this->canEdit($event, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canShow(Event $event, User $user)
    {
        // if they can edit, they can show
        if ($this->canEdit($event, $user)) {
            return true;
        }

        return $event->isActive();
    }

    private function canEdit(Event $event, User $user)
    {
        // Check if user is the one who created the event
        return $user === $event->getCreatedBy();
    }
}