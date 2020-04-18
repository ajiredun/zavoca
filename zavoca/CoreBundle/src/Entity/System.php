<?php

namespace Zavoca\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Zavoca\CoreBundle\Repository\SystemRepository")
 */
class System
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $websiteName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $websiteUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $systemEmail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $managementEmail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $emailLayoutPath;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="json")
     */
    private $modules = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $defaultDarkTheme;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getWebsiteName(): ?string
    {
        return $this->websiteName;
    }

    public function setWebsiteName(?string $websiteName): self
    {
        $this->websiteName = $websiteName;

        return $this;
    }

    public function getWebsiteUrl(): ?string
    {
        return $this->websiteUrl;
    }

    public function setWebsiteUrl(?string $websiteUrl): self
    {
        $this->websiteUrl = $websiteUrl;

        return $this;
    }

    public function getSystemEmail(): ?string
    {
        return $this->systemEmail;
    }

    public function setSystemEmail(?string $systemEmail): self
    {
        $this->systemEmail = $systemEmail;

        return $this;
    }

    public function getManagementEmail(): ?string
    {
        return $this->managementEmail;
    }

    public function setManagementEmail(?string $managementEmail): self
    {
        $this->managementEmail = $managementEmail;

        return $this;
    }

    public function getEmailLayoutPath(): ?string
    {
        return $this->emailLayoutPath;
    }

    public function setEmailLayoutPath(?string $emailLayoutPath): self
    {
        $this->emailLayoutPath = $emailLayoutPath;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getModules(): ?array
    {
        return $this->modules;
    }

    public function setModules(array $modules): self
    {
        $this->modules = $modules;

        return $this;
    }

    public function getDefaultDarkTheme(): ?bool
    {
        return $this->defaultDarkTheme;
    }

    public function setDefaultDarkTheme(bool $defaultDarkTheme): self
    {
        $this->defaultDarkTheme = $defaultDarkTheme;

        return $this;
    }
}
