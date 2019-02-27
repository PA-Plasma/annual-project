<?php

namespace App\Controller\Modules;

use App\Controller\Interfaces\ModuleInterface;
use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

Class TeamModuleController extends AbstractController implements ModuleInterface
{
    public function parameters(Event $event, Request $request)
    {
        // TODO: Implement edit() method.
    }

    public function display(Event $event, Request $request)
    {
        // TODO: Implement display() method.
    }
}
