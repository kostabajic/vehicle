<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MakeRepository")
 */
class Make
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VehicleType", inversedBy="makes")
     * @ORM\JoinColumn(nullable=true)
     */
    private $vehicle_type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Model", mappedBy="vehicle_type")
     */
    private $models;

    public function __construct() {
        $this->models = new ArrayCollection();
    }
    public function getId()
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
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
    
    public function setVehicleType(VehicleType $vehicle_type) {
        
        $this->vehicle_type = $vehicle_type;
        
    }
    
}
