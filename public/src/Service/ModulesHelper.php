<?php

namespace App\Service;



use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use \Doctrine\Common\Persistence\ManagerRegistry;

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

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    public $em;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();
    }

    public function FactoryModule(Event $event)
    {
        $modules = [];
        foreach ($event->getModules() as $module) {
            //controller permet d'appeller les fonctions d'un controller dans une vue twig (ex: render(controller($controllerModule)) )
            $controllerModule = static::moduleControllerNameSpace.ucfirst($module->getName()).static::suffixModuleControllerName;

            //on va chercher l'entité lié à l'event de manière dynamique
            $entityName = static::getEntityName($module->getName());
            $entity = $this->em->getRepository($entityName)->findOneBy(['event' => $event->getId()]);
            $modules[] = [
                'moduleName' => ucfirst($module->getName()), //module name
                'controller' => $controllerModule, //string qui contient le nom du controller
                'entity' => $entity //entity || null
            ];
        }
        return $modules;
    }

    public function generateModulesParameters(string $name, Event $event)
    {
        $entityName = static::getEntityName($name);
        $module = new $entityName();
        $module->setName($name);
        $module->setEvent($event);
        $this->em->persist($module);
        $this->em->flush();
        //tester sans le flush
    }

    protected static function getEntityName($name) {
        return static::moduleEntityNameSpace.static::prefixModuleEntityName.ucfirst($name);
    }
}