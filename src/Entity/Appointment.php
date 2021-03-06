<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AppointmentRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource(formats={"json"},
 *     forceEager=false,
 *     normalizationContext={"groups"={"appointment:read"},"enable_max_depth"=true},
 *     denormalizationContext={"groups"={"appointment:write"},"enable_max_depth"=true})
 * @ORM\Entity(repositoryClass=AppointmentRepository::class)
 */
class Appointment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"appointment:read","appointment:write","service:read","client:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="time")
     * @Groups({"appointment:read","appointment:write","service:read","client:read"})
     */
    private $startTime;

    /**
     * @ORM\Column(type="time")
     * @Groups({"appointment:read","appointment:write","service:read","client:read"})
     */
    private $endTime;

    /**
     * @ORM\Column(type="date")
     * @Groups({"appointment:read","appointment:write","service:read","client:read"})
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"appointment:read","appointment:write","service:read","client:read"})
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="appointments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"appointment:read","appointment:write"})
     */
    private $service;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="appointments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"appointment:read","appointment:write"})
     */
    private $client;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Gedmo\Timestampable(on="create")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
