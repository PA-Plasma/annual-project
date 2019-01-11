<?php

namespace App\Service;

use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

/**
 * Class RolesHelper
 *
 * @category  Class
 * @package   App\Service
 */
class RolesHelper
{
    /**
     * @var RoleHierarchyInterface $rolesRanking
     */
    private $rolesRanking;
    /**
     * @var array $roles
     */
    private $roles = [];

    /**
     * RolesHelper constructor.
     *
     * @param RoleHierarchyInterface $rolesRanking
     */
    public function __construct(RoleHierarchyInterface $rolesRanking)
    {
        $this->rolesRanking = $rolesRanking;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles(): array
    {
        if ($this->roles) {
            return $this->roles;
        }

        array_walk_recursive(
            $this->rolesRanking,
            function ($role) {
                $this->roles[$role] = $role;
            }
        );

        /** @var array $roles */
        $roles = array_unique($this->roles);

        return $this->roles = array_flip($roles);
    }
}
