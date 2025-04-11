<?php

namespace App\DataFixtures;

use App\Entity\Shift;
use App\Entity\Agent;
use App\Entity\Queue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ShiftFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $shifts = [
            [
                'agent' => 'john_smith',
                'queue' => 'sales',
                'start_time' => '2024-04-12 09:00:00',
                'end_time' => '2024-04-12 17:00:00'
            ],
            [
                'agent' => 'alice_johnson',
                'queue' => 'support',
                'start_time' => '2024-04-12 12:00:00',
                'end_time' => '2024-04-12 20:00:00'
            ],
            [
                'agent' => 'bob_wilson',
                'queue' => 'technical',
                'start_time' => '2024-04-12 08:00:00',
                'end_time' => '2024-04-12 16:00:00'
            ],
            [
                'agent' => 'emma_davis',
                'queue' => 'customer_service',
                'start_time' => '2024-04-12 10:00:00',
                'end_time' => '2024-04-12 18:00:00'
            ]
        ];

        foreach ($shifts as $shiftData) {
            $shift = new Shift();
            $shift->setAgent($this->getReference('agent_' . $shiftData['agent'], Agent::class));
            $shift->setQueue($this->getReference('queue_' . $shiftData['queue'], Queue::class));
            $shift->setStartTime(new \DateTime($shiftData['start_time']));
            $shift->setEndTime(new \DateTime($shiftData['end_time']));
            $manager->persist($shift);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AgentFixtures::class,
            QueueFixtures::class,
        ];
    }
} 