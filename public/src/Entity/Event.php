<?php

namespace App\Entity;

use App\Entity\Modules\ModuleTournament;
use App\Entity\Traits\ActiveTrait;
use App\Entity\Traits\SoftDeletedTrait;
use App\Entity\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @Vich\Uploadable
 */
class Event
{
    CONST REGISTRATION_TYPE_FREE = 1;
    CONST REGISTRATION_TYPE_PAYING = 2;

    use ActiveTrait;
    use SoftDeletedTrait;
    use TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $beginnig_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $registration_type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Entrant", mappedBy="event", cascade={"persist"})
     */
    private $entrants;

    /**
     * @ORM\Column(type="boolean")
     */
    private $invitation;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Address", inversedBy="event", cascade={"persist", "remove"})
     */
    private $Address;

    /**
     * @var string
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", nullable=true)
     */
    private $slug = null;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Modules", inversedBy="events")
     */
    private $modules;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Modules\ModuleTournament", mappedBy="event", cascade={"persist", "remove"})
     */
    private $moduleTournament;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="event", fileNameProperty="imageName", size="imageSize")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer
     */
    private $imageSize;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;


    public function __construct()
    {
        $this->entrants = new ArrayCollection();
        $this->modules = new ArrayCollection();
        $this->updatedAt = new\DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBeginnigDate(): ?\DateTimeInterface
    {
        return $this->beginnig_date;
    }

    public function setBeginnigDate(\DateTimeInterface $beginnig_date): self
    {
        $this->beginnig_date = $beginnig_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getRegistrationType(): ?int
    {
        return $this->registration_type;
    }

    public function setRegistrationType(int $registration_type): self
    {
        $this->registration_type = $registration_type;

        return $this;
    }

    public function getEntrants(): Collection
    {
        return $this->entrants;
    }

    public function addEntrant(Entrant $entrant): self
    {
        if (!$this->entrants->contains($entrant)) {
            $this->entrants->add($entrant);
            $entrant->setEvent($this);
        }

        return $this;
    }

    public function removeEntrant(Entrant $entrant): self
    {
        if ($this->entrants->contains($entrant)) {
            $this->entrants->removeElement($entrant);
            // set the owning side to null (unless already changed)
            if ($entrant->getEvent() === $this) {
                $entrant->setEvent(null);
            }
        }

        return $this;
    }

    public function getInvitation(): ?bool
    {
        return $this->invitation;
    }

    public function setInvitation(bool $invitation): self
    {
        $this->invitation = $invitation;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->Address;
    }

    public function setAddress(?Address $Address): self
    {
        $this->Address = $Address;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return Collection|Modules[]
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Modules $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules[] = $module;
        }

        return $this;
    }

    public function removeModule(Modules $module): self
    {
        if ($this->modules->contains($module)) {
            $this->modules->removeElement($module);
        }

        return $this;
    }

    public function getModuleTournament(): ?ModuleTournament
    {
        return $this->moduleTournament;
    }

    public function setModuleTournament(ModuleTournament $moduleTournament): self
    {
        $this->moduleTournament = $moduleTournament;

        // set the owning side of the relation if necessary
        if ($this !== $moduleTournament->getEvent()) {
            $moduleTournament->setEvent($this);
        }

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }
}
