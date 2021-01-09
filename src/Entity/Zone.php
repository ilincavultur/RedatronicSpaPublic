<?php

namespace App\Entity;

use App\Repository\ZoneRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ZoneRepository", repositoryClass=ZoneRepository::class)
 */
class Zone
{
    public const TYPE_YES = 'Yes';
    public const TYPE_NO = 'No';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(
     *     max = 255
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *     max = 255
     * )
     */
    private $inReader;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *     max = 255
     * )
     */
    private $outReader;

    /**
     * @ORM\Column(type="boolean")
     */
    private $mainEntrance;

    /**
     * @ORM\Column(type="boolean")
     */
    private $extra;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $Name): self
    {
        $this->name = $Name;

        return $this;
    }

    public function getInReader(): ?string
    {
        return $this->inReader;
    }

    public function setInReader(?string $inReader): self
    {
        $this->inReader = $inReader;

        return $this;
    }

    public function getOutReader(): ?string
    {
        return $this->outReader;
    }

    public function setOutReader(?string $outReader): self
    {
        $this->outReader = $outReader;

        return $this;
    }

    public function getMainEntrance(): ?bool
    {
        return $this->mainEntrance;
    }

    public function setMainEntrance(bool $mainEntrance): self
    {
        $this->mainEntrance = $mainEntrance;

        return $this;
    }

    public function getExtra(): ?bool
    {
        return $this->extra;
    }

    public function setExtra(bool $extra): self
    {
        $this->extra = $extra;

        return $this;
    }
}
