<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 */
class Users 
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=191, unique=true)
     * @Assert\NotBlank()
     * @Assert\Type(type="alnum")
     * @Assert\Length(
     *      min = 3,
     *      max = 50
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=191)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 8,
     *      max = 50
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=191, unique=true)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=191, nullable=true)
     * @Assert\Length(
     *      min = 3,
     *      max = 30
     * )
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=191, nullable=true)
     * @Assert\Length(
     *      min = 3,
     *      max = 50
     * )
     */
    private $lastname;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Assert\Type(type="\DateTime")
     */
    private $createdAt;
	
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Assert\Type(type="\DateTime")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();	
        $this->updatedAt = new \DateTime();			
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $this->crypted($password);

        return $this;
    }
	
    public function crypted($password): ?string
    {
        return  sha1(md5($password));
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
	
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
