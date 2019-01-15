<?php

namespace App\Entity\Traits;

trait SoftDeletedTrait
{
    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $deleted = false;

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }
    /**
     * @param bool $deleted
     *
     * @return SoftDeletedTrait
     */
    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;
        return $this;
    }
}