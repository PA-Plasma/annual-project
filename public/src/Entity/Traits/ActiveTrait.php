<?php

namespace App\Entity\Traits;

/**
 * Trait ActiveTrait
 *
 * @category  Trait
 * @package   App\Entity\Traits
 */
trait ActiveTrait
{
    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $active = false;

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @return ActiveTrait
     */
    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }
}