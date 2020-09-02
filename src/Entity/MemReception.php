<?php

namespace App\Entity;

use App\Repository\MemReceptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemReceptionRepository", repositoryClass=MemReceptionRepository::class)
 */
class MemReception
{
    use TimestampableEntity;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Membership")
     * @ORM\JoinColumn(name="membership_id", referencedColumnName="id")
     */
    private $Membership;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $Products;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Rfid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Age;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Membership|null
     */
    public function getMembership(): ?Membership
    {
        return $this->Membership;
    }

    /**
     * @param Membership $Membership
     * @return MemReception
     */
    public function setMembership(Membership $Membership): self
    {
        $this->Membership = $Membership;

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
     * @param $Products
     * @return $this
     */
    public function setProducts($Products)
    {
        $this->Products = $Products;

        return $this;
    }

    public function getRfid(): ?string
    {
        return $this->Rfid;
    }

    public function setRfid(string $Rfid): self
    {
        $this->Rfid = $Rfid;

        return $this;
    }

    public function getAge(): ?string
    {
        return $this->Age;
    }

    public function setAge(?string $Age): self
    {
        $this->Age = $Age;

        return $this;
    }
}
