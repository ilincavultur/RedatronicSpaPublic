<?php

namespace App\Entity;

use App\Repository\RfidRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RfidRepository::class)
 */
class Rfid
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Reception", inversedBy="Rfid")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Rfid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Reception;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRfid(): ?string
    {
        return $this->Rfid;
    }

    public function setRfid(?string $Rfid): self
    {
        $this->Rfid = $Rfid;

        return $this;
    }

    public function getReception(): ?string
    {
        return $this->Reception;
    }

    public function setReception(string $Reception): self
    {
        $this->Reception = $Reception;

        return $this;
    }
}
