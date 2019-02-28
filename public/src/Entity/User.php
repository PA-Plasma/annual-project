<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Traits\ActiveTrait;
use App\Entity\Traits\SoftDeletedTrait;
use App\Entity\Traits\TimestampableUserTrait;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user_account")
 *
 */
class User implements UserInterface
{
    use ActiveTrait;
    use SoftDeletedTrait;
    use TimestampableUserTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string
     * @Gedmo\Slug(fields={"pseudo"})
     * @ORM\Column(type="string", nullable=true)
     */
    private $slug = null;
  
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Entrant", mappedBy="user_related")
     */
    private $entrants;

    public function __construct()
    {
        $this->entrants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole($role): self
    {
        $role = strtoupper($role);

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug):? self
    {
        $this->slug = $slug;
        
        return $this;
    }

    public function getEntrants(): Collection
    {
        return $this->entrants;
    }

    public function addEntrant(Entrant $entrant): self
    {
        if (!$this->entrants->contains($entrant)) {
            $this->entrants[] = $entrant;
            $entrant->setUserRelated($this);
        }

        return $this;
    }

    public function removeEntrant(Entrant $entrant): self
    {
        if ($this->entrants->contains($entrant)) {
            $this->entrants->removeElement($entrant);
            // set the owning side to null (unless already changed)
            if ($entrant->getUserRelated() === $this) {
                $entrant->setUserRelated(null);
            }
        }
        return $this;
    }


}
