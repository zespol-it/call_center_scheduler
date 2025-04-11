<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    normalizationContext: ['groups' => ['agent:read']],
    denormalizationContext: ['groups' => ['agent:write']]
)]
class Agent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['agent:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['agent:read', 'agent:write', 'shift:read'])]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Queue::class, inversedBy: 'agents')]
    #[Groups(['agent:read', 'agent:write'])]
    private Collection $queues;

    #[ORM\OneToMany(targetEntity: Shift::class, mappedBy: 'agent')]
    #[Groups(['agent:read'])]
    private Collection $shifts;

    #[ORM\Column(type: 'json')]
    #[Groups(['agent:read', 'agent:write'])]
    private array $availability = [];

    #[ORM\Column(type: 'json')]
    #[Groups(['agent:read', 'agent:write'])]
    private array $efficiency = [];

    public function __construct()
    {
        $this->queues = new ArrayCollection();
        $this->shifts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getQueues(): Collection
    {
        return $this->queues;
    }

    public function addQueue(Queue $queue): static
    {
        if (!$this->queues->contains($queue)) {
            $this->queues->add($queue);
        }
        return $this;
    }

    public function removeQueue(Queue $queue): static
    {
        $this->queues->removeElement($queue);
        return $this;
    }

    public function getShifts(): Collection
    {
        return $this->shifts;
    }

    public function addShift(Shift $shift): static
    {
        if (!$this->shifts->contains($shift)) {
            $this->shifts->add($shift);
            $shift->setAgent($this);
        }
        return $this;
    }

    public function removeShift(Shift $shift): static
    {
        if ($this->shifts->removeElement($shift)) {
            if ($shift->getAgent() === $this) {
                $shift->setAgent(null);
            }
        }
        return $this;
    }

    public function getAvailability(): array
    {
        return $this->availability;
    }

    public function setAvailability(array $availability): static
    {
        $this->availability = $availability;
        return $this;
    }

    public function getEfficiency(): array
    {
        return $this->efficiency;
    }

    public function setEfficiency(array $efficiency): static
    {
        $this->efficiency = $efficiency;
        return $this;
    }
} 