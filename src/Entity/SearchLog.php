<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SearchLogRepository")
 */
class SearchLog
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
    private $vehicle_type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $make_abbr;

    /**
     * @ORM\Column(type="integer")
     */
    private $number_of_models;

    /**
     * @ORM\Column(type="datetime")
     */
    private $request_time;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ip_address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_agent;

    public function getId()
    {
        return $this->id;
    }

    public function getVehicleType(): ?string
    {
        return $this->vehicle_type;
    }

    public function setVehicleType(string $vehicle_type): self
    {
        $this->vehicle_type = $vehicle_type;

        return $this;
    }

    public function getMakeAbbr(): ?string
    {
        return $this->make_abbr;
    }

    public function setMakeAbbr(string $make_abbr): self
    {
        $this->make_abbr = $make_abbr;

        return $this;
    }
    public function setUserAgent($user_agent): self
    {
        $this->user_agent=$user_agent;

        return $this;
    }

    public function getNumberOfModels(): ?int
    {
        return $this->number_of_models;
    }

    public function setNumberOfModels(int $number_of_models): self
    {
        $this->number_of_models = $number_of_models;

        return $this;
    }

    public function getRequestTime(): ?\DateTimeInterface
    {
        return $this->request_time;
    }

    public function setRequestTime(\DateTimeInterface $request_time): self
    {
        $this->request_time = $request_time;

        return $this;
    }

    public function getIpAddress(): ?string
    {
        return $this->ip_address;
    }

    public function setIpAddress(string $ip_address): self
    {
        $this->ip_address = $ip_address;

        return $this;
    }

    public function getUserAgent(): ?string
    {
        return $this->user_agent;
    }


}
