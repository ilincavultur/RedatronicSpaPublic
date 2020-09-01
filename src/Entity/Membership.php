<?php

namespace App\Entity;

use App\Repository\MembershipRepository;
use Doctrine\Common\Collections\ArrayCollection;
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
     */
    private $ClientName;


    /**
     * @ORM\ManyToMany(targetEntity="Package")
     * @ORM\JoinColumn(name="package_id", referencedColumnName="id")
     *
     */
    private $Packages;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    private $Age;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(
     *     max = 255
     * )
     */
    private $RFID;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientName(): ?string
    {
        return $this->ClientName;
    }

    /**
     * @param string|null $ClientName
     * @return Membership
     */
    public function setClientName(?string $ClientName): self
    {
        $this->ClientName = $ClientName;

        return $this;
    }


    /**
     * @return ArrayCollection
     */
    public function getPackages()
    {
        return $this->Packages;
    }

    /**
     * @param $Packages
     * @return $this
     */
    public function setPackages($Packages)
    {
        $this->Packages = $Packages;

        return $this;
    }



    /**
     * @return string|null
     */
    public function getAge(): ?string
    {
        return $this->Age;
    }

    /**
     * @param string $Age
     * @return Membership
     */
    public function setAge(string $Age): self
    {
        $this->Age = $Age;

        return $this;
    }





    public function getRFID(): ?string
    {
        return $this->RFID;
    }

    /**
     * @param string $RFID
     * @return Membership
     */
    public function setRFID(string $RFID): self
    {
        $this->RFID = $RFID;

        return $this;
    }


}
