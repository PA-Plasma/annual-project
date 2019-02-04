<?php

namespace App\Service;



use App\Entity\Event;

/**
 * Class RolesHelper
 *
 * @category  Class
 * @package   App\Service
 */
class ModulesHelper
{
    const moduleNameSpace = 'App\\Service\\Modules\\';
    const suffixModuleName = 'ModuleHelper';

    public static function FactoryModuleService(Event $event)
    {
        $modulesHelpers = [];
        foreach ($event->getModules() as $module) {
            $helperName = static::moduleNameSpace.ucfirst($module->getName()).static::suffixModuleName;
            $modulesHelpers[] = new $helperName();
        }
        return $modulesHelpers;
    }
}