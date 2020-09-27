<?php

namespace App\Entity;

use App\Repository\ReceptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\Timestampable;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ReceptionRepository", repositoryClass=ReceptionRepository::class)
 */
class Reception
{
    public const TYPE_ADULT = 'Adult';
    public const TYPE_CHILD = 'Child';

    public const TYPE_TEN = 10;
    public const TYPE_FIFTY = 50;
    public const TYPE_HUNDRED = 100;

    use TimestampableEntity;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;





    /**
     * @ORM\ManyToOne(targetEntity="Package")
     * @ORM\JoinColumn(name="package_id", referencedColumnName="id")
     *
     */
    private $Package;

    /**
     * @ORM\ManyToMany(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *
     */
    private $Products;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Adults;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Children;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $totalPers;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $totalAccess;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $totalServices;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $totalSum;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Credit;

    /**
     * @ORM\OneToMany(targetEntity="Rfid",mappedBy="Reception", cascade={"persist"})
     *


     */
    private $Rfids;





    public function getId(): ?int
    {
        return $this->id;
    }

   



    /**
     * @return mixed
     */
    public function getPackage()
    {
        return $this->Package;
    }

    /**
     * @param $Package
     * @return $this
     */
    public function setPackage($Package)
    {
        $this->Package = $Package;

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

    public function getAdults(): ?int
    {
        return $this->Adults;
    }

    public function setAdults(?int $Adults): self
    {
        $this->Adults = $Adults;

        return $this;
    }

    public function getChildren(): ?int
    {
        return $this->Children;
    }

    public function setChildren(?int $Children): self
    {
        $this->Children = $Children;

        return $this;
    }

    public function getTotalPers(): ?int
    {
        return $this->totalPers;
    }

    public function setTotalPers(?int $totalPers): self
    {
        $this->totalPers = $totalPers;

        return $this;
    }

    public function getTotalAccess(): ?int
    {
        return $this->totalAccess;
    }

    public function setTotalAccess(?int $totalAccess): self
    {
        $this->totalAccess = $totalAccess;

        return $this;
    }

    public function getTotalServices(): ?int
    {
        return $this->totalServices;
    }

    public function setTotalServices(?int $totalServices): self
    {
        $this->totalServices = $totalServices;

        return $this;
    }

    public function getTotalSum(): ?int
    {
        return $this->totalSum;
    }

    public function setTotalSum(?int $totalSum): self
    {
        $this->totalSum = $totalSum;

        return $this;
    }

    public function getCredit(): ?int
    {
        return $this->Credit;
    }

    public function setCredit(?int $Credit): self
    {
        $this->Credit = $Credit;

        return $this;
    }



    /**
     * @param Rfid $tag
     */
    public function addTag(Rfid $tag)
    {

        $tag->setRfid($this);

        $this->Rfids->add($tag);
    }

    public function removeTag(Rfid $tag)
    {
        $this->Rfids->removeElement($tag);
    }

    /**
     * @return ArrayCollection
     */
    public function getRfids()
    {
        return $this->Rfids;
    }

    /**
     * @param string $Rfids
     * @return $this
     */
    public function setRfids($Rfids)
    {
        $this->Rfids = $Rfids;

        return $this;
    }






}
