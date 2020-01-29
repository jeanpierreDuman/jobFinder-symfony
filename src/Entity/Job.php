<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobRepository")
 */
class Job
{
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
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $domain;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subway;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Criteria", mappedBy="job", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $criterias;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="jobs")
     */
    private $applies;

    /**
     * @ORM\Column(type="array")
     */
    private $conditions = [];

    /**
     * @ORM\Column(type="integer")
     */
    private $limitApply;

    public function __construct()
    {
        $this->criterias = new ArrayCollection();
        $this->applies = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    public function getSubway(): ?string
    {
        return $this->subway;
    }

    public function setSubway(string $subway): self
    {
        $this->subway = $subway;

        return $this;
    }

    /**
     * @return Collection|Criteria[]
     */
    public function getCriterias(): Collection
    {
        return $this->criterias;
    }

    public function addCriteria(Criteria $criteria): self
    {
        if (!$this->criterias->contains($criteria)) {
            $this->criterias[] = $criteria;
            $criteria->setJob($this);
        }

        return $this;
    }

    public function removeCriteria(Criteria $criteria): self
    {
        if ($this->criterias->contains($criteria)) {
            $this->criterias->removeElement($criteria);
            // set the owning side to null (unless already changed)
            if ($criteria->getJob() === $this) {
                $criteria->setJob(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getApplies(): Collection
    {
        return $this->applies;
    }

    public function addApply(User $apply): self
    {
        if (!$this->applies->contains($apply)) {
            $this->applies[] = $apply;
        }

        return $this;
    }

    public function removeApply(User $apply): self
    {
        if ($this->applies->contains($apply)) {
            $this->applies->removeElement($apply);
        }

        return $this;
    }

    public function containsUser(User $user)
    {
        if($this->applies->contains($user)) {
            return true;
        }

        return false;
    }

    public function getConditions(): ?array
    {
        return $this->conditions;
    }

    public function setConditions(array $conditions): self
    {
        $this->conditions = $conditions;

        return $this;
    }

    public function getLimitApply(): ?int
    {
        return $this->limitApply;
    }

    public function setLimitApply(int $limitApply): self
    {
        $this->limitApply = $limitApply;

        return $this;
    }
}
