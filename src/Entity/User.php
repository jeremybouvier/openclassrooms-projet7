<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="user", orphanRemoval=true)
     */
    private $customers;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="integer")
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    public function __construct()
    {
        $this->customers = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return Collection|Customer[]
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }
    public function addCustumer(Customer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers[] = $customer;
            $customer->setUser($this);
        }
        return $this;
    }
    public function removeCustomer(Customer $customer): self
    {
        if ($this->customers->contains($customer)) {
            $this->customers->removeElement($customer);
            // set the owning side to null (unless already changed)
            if ($customer->getUser() === $this) {
                $customer->setUser(null);
            }
        }
        return $this;
    }
    public function getCompany(): ?string
    {
        return $this->company;
    }
    public function setCompany(string $company): self
    {
        $this->company = $company;
        return $this;
    }
    public function getAddress(): ?string
    {
        return $this->address;
    }
    public function setAddress(string $address): self
    {
        $this->address = $address;
        return $this;
    }
    public function getCity(): ?string
    {
        return $this->city;
    }
    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }
    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }
    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;
        return $this;
    }
    public function getPhone(): ?string
    {
        return $this->phone;
    }
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }
    public function eraseCredentials()
    {
    }
}
