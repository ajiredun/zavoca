<?php

namespace Zavoca\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="Zavoca\CoreBundle\Repository\UserRepository")
 */
class User extends \App\EntityZavoca\User
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $backgroundLogo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $backgroundSidebar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $backgroundNavbar;


    /**
     * @ORM\Column(type="boolean")
     */
    private $autoDarkMode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $activation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mobile;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastActive;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $darkTheme;

    public function __construct()
    {

        parent::__construct();
        $this->createdAt = new \DateTime('now');
        $this->darkTheme = false;
        $this->backgroundLogo = 'skin5';
        $this->backgroundNavbar = 'skin5';
        $this->backgroundSidebar = 'skin6';
        $this->country = "MU";
        $this->autoDarkMode = false;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isActiveNow()
    {
        // Delay during wich the user will be considered as still active
        $delay = new \DateTime('5 minutes ago');

        return ( $this->getLastactive() > $delay );
    }

    public function getName()
    {
        return $this->getFirstname() . " " . $this->getLastname();
    }

    public function getAutoDarkMode(): ?bool
    {
        return $this->autoDarkMode;
    }

    public function setAutoDarkMode(bool $autoDarkMode): self
    {
        $this->autoDarkMode = $autoDarkMode;

        return $this;
    }

    public function getBackgroundLogo(): ?string
    {
        return $this->backgroundLogo;
    }

    public function setBackgroundLogo(string $backgroundLogo): self
    {
        $this->backgroundLogo = $backgroundLogo;

        return $this;
    }

    public function getBackgroundSidebar(): ?string
    {
        return $this->backgroundSidebar;
    }

    public function setBackgroundSidebar(string $backgroundSidebar): self
    {
        $this->backgroundSidebar = $backgroundSidebar;

        return $this;
    }

    public function getBackgroundNavbar(): ?string
    {
        return $this->backgroundNavbar;
    }

    public function setBackgroundNavbar(string $backgroundNavbar): self
    {
        $this->backgroundNavbar = $backgroundNavbar;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getActivation(): ?string
    {
        return $this->activation;
    }

    public function setActivation(string $activation): self
    {
        $this->activation = $activation;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(?string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getLastActive(): ?\DateTimeInterface
    {
        return $this->lastActive;
    }

    public function setLastActive(?\DateTimeInterface $lastActive): self
    {
        $this->lastActive = $lastActive;

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

    public function getDarkTheme(): ?bool
    {
        return $this->darkTheme;
    }

    public function setDarkTheme(bool $darkTheme): self
    {
        $this->darkTheme = $darkTheme;

        return $this;
    }
}
