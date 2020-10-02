<?php

namespace App\Entity;

use App\Repository\CircuitRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CircuitRepository", repositoryClass=CircuitRepository::class)
 *
 */
class Circuit
{
    use TimestampableEntity;


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *     max = 255
     * )
     *
     */
    private $rfid;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isOpen;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endTime;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRfid(): ?string
    {
        return $this->rfid;
    }

    public function setRfid(string $Rfid): self
    {
        $this->rfid = $Rfid;

        return $this;
    }

    public function getIsOpen(): ?bool
    {
        return $this->isOpen;
    }

    public function setIsOpen(bool $isOpen): self
    {
        $this->isOpen = $isOpen;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(?\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }




}
