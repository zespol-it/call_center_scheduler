<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['demand_forecast:read']],
    denormalizationContext: ['groups' => ['demand_forecast:write']]
)]
class DemandForecast
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['demand_forecast:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Queue::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['demand_forecast:read', 'demand_forecast:write'])]
    private ?Queue $queue = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['demand_forecast:read', 'demand_forecast:write'])]
    private ?\DateTimeInterface $timestamp = null;

    #[ORM\Column(type: 'integer')]
    #[Groups(['demand_forecast:read', 'demand_forecast:write'])]
    private ?int $expectedCalls = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQueue(): ?Queue
    {
        return $this->queue;
    }

    public function setQueue(?Queue $queue): static
    {
        $this->queue = $queue;
        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): static
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    public function getExpectedCalls(): ?int
    {
        return $this->expectedCalls;
    }

    public function setExpectedCalls(int $expectedCalls): static
    {
        $this->expectedCalls = $expectedCalls;
        return $this;
    }
} 