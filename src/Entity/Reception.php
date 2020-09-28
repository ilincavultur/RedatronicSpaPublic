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


    public const TYPE_TEN = 10;
    public const TYPE_FIFTY = 50;
    public const TYPE_HUNDRED = 100;

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
     * @ORM\Column(type="string", length=255, nullable=true)
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

    public function getRfid(): ?string
    {
        return $this->Rfid;
    }

    public function setRfid(?string $Rfid): self
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
