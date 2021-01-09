<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository", repositoryClass=ProductRepository::class)
 *
 */
class Product
{
    use TimestampableEntity;

    public const TYPE_RESTAURANT = 'Restaurant';
    public const TYPE_BAR = 'Bar';
    public const TYPE_SERVICE = 'Service';

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
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *     max = 255
     * )
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *     max = 255
     * )
     */
    private $barcode;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $weekendPrice;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *     max = 255
     * )
     */
    private $type;


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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $Code): self
    {
        $this->code = $Code;

        return $this;
    }

    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    public function setBarcode(?string $Barcode): self
    {
        $this->barcode = $Barcode;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $Price): self
    {
        $this->price = $Price;

        return $this;
    }

    public function getWeekendPrice(): ?int
    {
        return $this->weekendPrice;
    }

    public function setWeekendPrice(int $WeekendPrice): self
    {
        $this->weekendPrice = $WeekendPrice;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $Type): self
    {
        $this->type = $Type;

        return $this;
    }

}
