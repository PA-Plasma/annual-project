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
    const moduleControllerNameSpace = 'App\\Controller\\Modules\\';
    const suffixModuleControllerName = 'ModuleController';
    const moduleEntityNameSpace = 'App\\Entity\\Modules\\';
    const prefixModuleEntityName = 'Module';

    public static function FactoryModule(Event $event, EntityManagerInterface $em)
    {
        $modules = [];
        foreach ($event->getModules() as $module) {
            //controller permet d'appeller les fonctions d'un controller dans une vue twig (ex: render(controller($controllerModule)) )
            $controllerModule = static::moduleControllerNameSpace.ucfirst($module->getName()).static::suffixModuleControllerName;

            //on va chercher l'entité lié à l'event de manière dynamique
            $entityName = static::moduleEntityNameSpace.static::prefixModuleEntityName.ucfirst($module->getName());
            $entity = $em->getRepository($entityName)->findOneBy(['event' => $event->getId()]);

            $modules[] = [
                'moduleName' => ucfirst($module->getName()), //module name
                'controller' => $controllerModule, //string qui contient le nom du controller
                'entity' => $entity //entity || null
            ];
        }
        return $modules;
    }
}