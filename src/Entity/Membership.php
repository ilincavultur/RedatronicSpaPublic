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
     * @ORM\Column(type="integer")
     */
    private $availability;


    /**
     * @ORM\ManyToMany(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *
     */
    private $Products;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    private $Age;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $NoOfEntries;

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
     * @return string|null
     */
    public function getAvailability(): ?string
    {
        return $this->availability;
    }

    /**
     * @param string $availability
     * @return Membership
     */
    public function setAvailability(string $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getProducts()
    {
        return $this->Products;
    }

    /**
     * @param string $Products
     * @return $this
     */
    public function setProducts($Products)
    {
        $this->Products = $Products;

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



    public function getNoOfEntries(): ?int
    {
        return $this->NoOfEntries;
    }

    public function setNoOfEntries(?int $NoOfEntries): self
    {
        $this->NoOfEntries = $NoOfEntries;

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
