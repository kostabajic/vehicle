<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModelRepository")
 */
class Model
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
     * @ORM\ManyToOne(targetEntity="App\Entity\VehicleType", inversedBy="models")
     * @ORM\JoinColumn(nullable=true)
     */
    private $vehicle_type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Make", inversedBy="models")
     * @ORM\JoinColumn(nullable=true)
     */
    private $make;
    
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
    
    public function setVehicleType(VehicleType $vehicle_type) {
        $this->vehicle_type = $vehicle_type;
    }

    public function setMake(Make $make) {
        $this->make = $make;
    }
    
    public function getVehicleType(): VehicleType {
        return $this->vehicle_type;
    }

    public function getMake(): Make {
        return $this->make;
    }
    
    
}
