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
    private $membership;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $products;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $rfid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $age;

    /**
     * @ORM\ManyToOne(targetEntity="Package")
     * @ORM\JoinColumn(name="package_id", referencedColumnName="id")
     */
    private $package;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $clientName;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Membership|null
     */
    public function getMembership(): ?Membership
    {
        return $this->membership;
    }

    /**
     * @param Membership $Membership
     * @return MemReception
     */
    public function setMembership(Membership $Membership): self
    {
        $this->membership = $Membership;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param $Products
     * @return $this
     */
    public function setProducts($Products)
    {
        $this->products = $Products;

        return $this;
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

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(?string $Age): self
    {
        $this->age = $Age;

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

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    public function setClientName(string $ClientName): self
    {
        $this->clientName = $ClientName;

        return $this;
    }
}
