<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
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
    private $LoginName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="user", orphanRemoval=true)
     */
    private $custumers;

    public function __construct()
    {
        $this->custumers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLoginName(): ?string
    {
        return $this->LoginName;
    }

    public function setLoginName(string $LoginName): self
    {
        $this->LoginName = $LoginName;

        return $this;
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

    /**
     * @return Collection|Customer[]
     */
    public function getCustumers(): Collection
    {
        return $this->custumers;
    }

    public function addCustumer(Customer $custumer): self
    {
        if (!$this->custumers->contains($custumer)) {
            $this->custumers[] = $custumer;
            $custumer->setUser($this);
        }

        return $this;
    }

    public function removeCustumer(Customer $custumer): self
    {
        if ($this->custumers->contains($custumer)) {
            $this->custumers->removeElement($custumer);
            // set the owning side to null (unless already changed)
            if ($custumer->getUser() === $this) {
                $custumer->setUser(null);
            }
        }

        return $this;
    }
}
