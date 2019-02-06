<?php

namespace App\Service;



use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;

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
            $entityName = static::getEntityName($module->getName());
            $entity = $em->getRepository($entityName)->findOneBy(['event' => $event->getId()]);
            $modules[] = [
                'moduleName' => ucfirst($module->getName()), //module name
                'controller' => $controllerModule, //string qui contient le nom du controller
                'entity' => $entity //entity || null
            ];
        }
        return $modules;
    }

    public static function generateModulesParameters(string $name, Event $event, EntityManagerInterface $em)
    {
        $entityName = static::getEntityName($name);
        $module = new $entityName();
        $module->setEvent($event);
        dump($module);
        $em->persist($module);
        $em->flush();
        //tester sans le flush
    }

    protected static function getEntityName($name) {
        return static::moduleEntityNameSpace.static::prefixModuleEntityName.ucfirst($name);
    }
}