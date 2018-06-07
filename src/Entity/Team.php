<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 */
class Team
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Groups", inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $groupstage;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Matchs", mappedBy="team")
     */
    private $matches;

    public function __construct()
    {
        $this->matches = new ArrayCollection();
    }

    public function getId()
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

    public function getGroupstage(): ?Group
    {
        return $this->groupstage;
    }

    public function setGroupstage(?Group $groupstage): self
    {
        $this->groupstage = $groupstage;

        return $this;
    }

    /**
     * @return Collection|Match[]
     */
    public function getMatches(): Collection
    {
        return $this->matches;
    }

    public function addMatch(Match $match): self
    {
        if (!$this->matches->contains($match)) {
            $this->matches[] = $match;
            $match->addTeam($this);
        }

        return $this;
    }

    public function removeMatch(Match $match): self
    {
        if ($this->matches->contains($match)) {
            $this->matches->removeElement($match);
            $match->removeTeam($this);
        }

        return $this;
    }
}
