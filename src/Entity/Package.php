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
    private $name;


    /**
     * @ORM\ManyToMany(targetEntity="Zone")
     * @ORM\JoinColumn(name="zone_id", referencedColumnName="id")
     *
     */
    private $zones;

    /**
     * @ORM\Column(type="integer")
     */
    private $availability;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $noOfEntries;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priceAdult;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priceChild;



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


    /**
     * @return ArrayCollection
     */
    public function getZones()
    {
        return $this->zones;
    }

    /**
     * @param string $Zones
     * @return $this
     */
    public function setZones($Zones)
    {
        $this->zones = $Zones;

        return $this;
    }

    public function getAvailability(): ?int
    {
        return $this->availability;
    }

    public function setAvailability(int $Availability): self
    {
        $this->availability = $Availability;

        return $this;
    }

    public function getNoOfEntries(): ?int
    {
        return $this->noOfEntries;
    }

    public function setNoOfEntries(?int $NoOfEntries): self
    {
        $this->noOfEntries = $NoOfEntries;

        return $this;
    }

    public function getPriceAdult(): ?int
    {
        return $this->priceAdult;
    }

    public function setPriceAdult(?int $priceAdult): self
    {
        $this->priceAdult = $priceAdult;

        return $this;
    }

    public function getPriceChild(): ?int
    {
        return $this->priceChild;
    }

    public function setPriceChild(?int $priceChild): self
    {
        $this->priceChild = $priceChild;

        return $this;
    }




}
