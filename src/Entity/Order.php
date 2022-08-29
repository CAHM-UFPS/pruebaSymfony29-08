<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Regex('/\d/', "Articlename can't contain numbers", null, false)]
    private ?string $articlename = null;

    #[ORM\Column]
    #[Assert\Positive]
    #[Assert\NotBlank]
    private ?int $quantity = null;

    #[ORM\Column]
    #[Assert\Positive]
    #[Assert\NotBlank]
    private ?int $unitaryprice = null;

    #[ORM\Column]
    #[Assert\Positive]
    #[Assert\NotBlank]
    private ?int $discount = null;

    #[ORM\Column]
    #[Assert\Positive]
    #[Assert\NotBlank]
    private ?int $userid = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticlename(): ?string
    {
        return $this->articlename;
    }

    public function setArticlename(string $articlename): self
    {
        $this->articlename = $articlename;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnitaryprice(): ?int
    {
        return $this->unitaryprice;
    }

    public function setUnitaryprice(int $unitaryprice): self
    {
        $this->unitaryprice = $unitaryprice;

        return $this;
    }

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function setDiscount(int $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getUserid(): ?int
    {
        return $this->userid;
    }

    public function setUserid(int $userid): self
    {
        $this->userid = $userid;

        return $this;
    }
}
