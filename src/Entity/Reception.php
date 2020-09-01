<?php

namespace App\Entity;

use App\Repository\ReceptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
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


    use TimestampableEntity;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Rfid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     */
    private $Age;

    /**
     * @ORM\ManyToMany(targetEntity="Package")
     * @ORM\JoinColumn(name="package_id", referencedColumnName="id")
     *
     */
    private $Packages;

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

    public function getRfid(): ?string
    {
        return $this->Rfid;
    }

    public function setRfid(string $Rfid): self
    {
        $this->Rfid = $Rfid;

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
     * @return Reception
     */
    public function setAge(string $Age): self
    {
        $this->Age = $Age;

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



}
