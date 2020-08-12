<?php

namespace App\Entity;

use App\Repository\PackageRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PackageRepository", repositoryClass=PackageRepository::class)
 */
class Package
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
     * @Assert\NotBlank
     * @Assert\Length(
     *     max = 255
     * )
     */
    private $Name;

    /**
     * @ORM\Column(type="integer")
     */
    private $Price;

    /**
     * @ORM\ManyToMany(targetEntity="Zone")
     * @ORM\JoinColumn(name="zone_id", referencedColumnName="id")
     *
     */
    private $Zones;

    /**
     * @ORM\ManyToMany(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *
     */
    private $Products;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->Price;
    }

    public function setPrice(int $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getZones()
    {
        return $this->Zones;
    }

    /**
     * @param string $Zones
     * @return $this
     */
    public function setZones($Zones)
    {
        $this->Zones = $Zones;

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


}
