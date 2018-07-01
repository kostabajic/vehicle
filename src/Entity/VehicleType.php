<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehicleTypeRepository")
 */
class VehicleType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;
    
     /**
     * @ORM\OneToMany(targetEntity="App\Entity\Model", mappedBy="vehicle_type")
     */
    private $models;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Make", mappedBy="vehicle_type")
     */
    private $makes;

    public function __construct() {
        $this->models = new ArrayCollection();
        $this->makes = new ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
    
    /**
     * @return Collection|Models[]
     */
    public function getModels() {
        return $this->models;
    }

    /**
     * @return Collection|Makes[]
     */
    public function getMakes() {
        return $this->models;
    }
}
