<?php

namespace App\Entity;

use App\Form\ReceptionType;
use App\Repository\RfidRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RfidRepository", repositoryClass=RfidRepository::class)
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
     *  
     * @ORM\Column(type="string")
     *
     */
    private $Rfid;

    /**
     * @ORM\ManyToOne(targetEntity="Reception", inversedBy="Rfids")
     * @ORM\JoinColumn(name="reception_id", referencedColumnName="id")
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

    public function setReception(?string $Reception): self
    {
        $this->Reception = $Reception;

        return $this;
    }




}
