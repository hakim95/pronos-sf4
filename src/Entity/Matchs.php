<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MatchsRepository")
 */
class Matchs
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $matchgroup;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Team", inversedBy="matches")
     */
    private $team;

    /**
     * @ORM\Column(type="integer")
     */
    private $appearance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $step;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function __construct()
    {
        $this->team = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMatchgroup(): ?bool
    {
        return $this->matchgroup;
    }

    public function setMatchgroup(bool $matchgroup): self
    {
        $this->matchgroup = $matchgroup;

        return $this;
    }

    /**
     * @return Collection|Team[]
     */
    public function getTeam(): Collection
    {
        return $this->team;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->team->contains($team)) {
            $this->team[] = $team;
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->team->contains($team)) {
            $this->team->removeElement($team);
        }

        return $this;
    }

    public function getAppearance(): ?int
    {
        return $this->appearance;
    }

    public function setAppearance(int $appearance): self
    {
        $this->appearance = $appearance;

        return $this;
    }

    public function getStep(): ?string
    {
        return $this->step;
    }

    public function setStep(?string $step): self
    {
        $this->step = $step;

        return $this;
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
}
