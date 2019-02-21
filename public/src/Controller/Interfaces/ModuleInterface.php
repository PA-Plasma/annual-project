<?php

namespace App\Controller\Interfaces;

use App\Entity\Event;
use Symfony\Component\HttpFoundation\Request;

interface ModuleInterface {
    public function parameters(Event $event, Request $request);
    public function display(Event $event, Request $request);
}