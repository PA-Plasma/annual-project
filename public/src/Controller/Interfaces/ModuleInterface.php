<?php

namespace App\Controller\Interfaces;

use App\Entity\Event;
use Symfony\Component\HttpFoundation\Request;

interface ModuleInterface {
    public function new(Event $event, Request $request);
    public function edit(Event $event, Request $request);
    public function display(Event $event, Request $request);
}