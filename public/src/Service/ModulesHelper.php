<?php

namespace App\Service;



use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class RolesHelper
 *
 * @category  Class
 * @package   App\Service
 */
class ModulesHelper
{
    const MODULE_CONTROLLER_NAMESPACE = 'App\\Controller\\Modules\\';
    const SUFFIX_MODULE_CONTROLLER_NAME = 'ModuleController';
    const MODULE_ENTITY_NAMESPACE = 'App\\Entity\\Modules\\';
    const PREFIX_MODULE_ENTITY_NAME = 'Module';

    public static function FactoryModule(Event $event, EntityManagerInterface $entityMaganer)
    {
        $modules = [];
        foreach ($event->getModules() as $module) {
            //controller permet d'appeller les fonctions d'un controller dans une vue twig (ex: render(controller($controllerModule)) )
            $controllerModule = static::MODULE_CONTROLLER_NAMESPACE.ucfirst($module->getName()).static::SUFFIX_MODULE_CONTROLLER_NAME;

            //on va chercher l'entité lié à l'event de manière dynamique
            $entityName = static::MODULE_ENTITY_NAMESPACE.static::PREFIX_MODULE_ENTITY_NAME.ucfirst($module->getName());
            $entity = $entityMaganer->getRepository($entityName)->findOneBy(['event' => $event->getId()]);

            $modules[] = [
                'moduleName' => ucfirst($module->getName()), //module name
                'controller' => $controllerModule, //string qui contient le nom du controller
                'entity' => $entity //entity || null
            ];
        }
        return $modules;
    }
}