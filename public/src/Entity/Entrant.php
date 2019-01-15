<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntrantRepository")
 */
class Entrant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="entrants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_related;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="entrants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="integer")
     */
    private $state;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserRelated(): ?User
    {
        return $this->user_related;
    }

    public function setUserRelated(?User $user_related): self
    {
        $this->user_related = $user_related;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }
}
