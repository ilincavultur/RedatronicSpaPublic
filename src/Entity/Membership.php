<?php

namespace App\Entity;

use App\Repository\MembershipRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MembershipRepository", repositoryClass=MembershipRepository::class)
 */
class Membership
{
    public const TYPE_ADULT = 'Adult';
    public const TYPE_CHILD = 'Child';
    use TimestampableEntity;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *     max = 255
     * )
     */
    private $clientName;


    /**
     * @ORM\ManyToOne(targetEntity="Package")
     * @ORM\JoinColumn(name="package_id", referencedColumnName="id")
     *
     */
    private $package;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(
     *     max = 255
     * )
     */
    private $age;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(
     *     max = 255
     * )
     */
    private $rfid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    /**
     * @param string|null $ClientName
     * @return Membership
     */
    public function setClientName(?string $ClientName): self
    {
        $this->clientName = $ClientName;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * @param $Package
     * @return $this
     */
    public function setPackage($Package)
    {
        $this->package = $Package;

        return $this;
    }



    /**
     * @return string|null
     */
    public function getAge(): ?string
    {
        return $this->age;
    }

    /**
     * @param string $Age
     * @return Membership
     */
    public function setAge(string $Age): self
    {
        $this->age = $Age;

        return $this;
    }

    public function getRFID(): ?string
    {
        return $this->rfid;
    }

    /**
     * @param string $RFID
     * @return Membership
     */
    public function setRFID(string $RFID): self
    {
        $this->rfid = $RFID;

        return $this;
    }


}
