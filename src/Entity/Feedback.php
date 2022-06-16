<?php

namespace App\Entity;

use App\Repository\FeedbackRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource(formats={"json"},
 *     forceEager=false,
 *     normalizationContext={"groups"={"feedback:read"},"enable_max_depth"=true},
 *     denormalizationContext={"groups"={"feedback:write"},"enable_max_depth"=true})
 * @ORM\Entity(repositoryClass=FeedbackRepository::class)
 */
class Feedback
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"feedback:read","feedback:write","service:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"feedback:read","feedback:write","service:read"})
     */
    private $rating;

    /**
     * @ORM\Column(type="text")
     * @Groups({"feedback:read","feedback:write","service:read"})
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="feedbacks")
     * @Groups({"feedback:read","feedback:write"})
     */
    private $service;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="feedbacks")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"feedback:read","feedback:write"})
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

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

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
