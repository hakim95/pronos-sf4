<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PronosticsRepository")
 */
class Pronostics
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Matchs", inversedBy="pronostics")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contest;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $score;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="pronostics")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pronouser;

    public function getId()
    {
        return $this->id;
    }

    public function getContest(): ?Matchs
    {
        return $this->contest;
    }

    public function setContest(?Matchs $contest): self
    {
        $this->contest = $contest;

        return $this;
    }

    public function getScore(): ?string
    {
        return $this->score;
    }

    public function setScore(string $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getPronouser(): ?User
    {
        return $this->pronouser;
    }

    public function setPronouser(?User $pronouser): self
    {
        $this->pronouser = $pronouser;

        return $this;
    }
}
