<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 *   @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "api_get_users",
 *          parameters = { "userId" = "expr(object.getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="ShowUsers")
 *      )
 *
 *   @Hateoas\Relation(
 *      "delete",
 *      href = @Hateoas\Route(
 *          "api_delete_user",
 *          parameters = { "userId" = "expr(object.getId())" },
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="ShowUsers")
 *   )
 *
 *  *   @Hateoas\Relation(
 *      "add",
 *      href = @Hateoas\Route(
 *          "api_post_user",
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="ShowUsers")
 *   )
 *
 *
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["ShowUserDetails"])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(["ShowUsers"])]
    private ?string $firstname = null;

    #[ORM\Column(length: 100)]
    #[Groups(["ShowUsers"])]
    private ?string $lastname = null;

    #[ORM\Column(length: 100)]
    #[Groups(["ShowUsers"])]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(["ShowUsersDetails"])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[Groups(["ShowUsersDetails"])]
    private ?customer $customer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCustomer(): ?customer
    {
        return $this->customer;
    }

    public function setCustomer(?customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }
}
