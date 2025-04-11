<?php

namespace App\DataFixtures;

use App\Entity\Agent;
use App\Entity\Queue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AgentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $agents = [
            [
                'name' => 'John Smith',
                'availability' => [
                    'monday' => ['9-17'],
                    'tuesday' => ['9-17'],
                    'wednesday' => ['9-17'],
                    'thursday' => ['9-17'],
                    'friday' => ['9-17']
                ],
                'efficiency' => [
                    'sales' => 0.9,
                    'support' => 0.7
                ],
                'queues' => ['sales', 'support']
            ],
            [
                'name' => 'Alice Johnson',
                'availability' => [
                    'monday' => ['12-20'],
                    'tuesday' => ['12-20'],
                    'wednesday' => ['12-20'],
                    'thursday' => ['12-20'],
                    'friday' => ['12-20']
                ],
                'efficiency' => [
                    'support' => 0.95,
                    'technical' => 0.8
                ],
                'queues' => ['support', 'technical']
            ],
            [
                'name' => 'Bob Wilson',
                'availability' => [
                    'monday' => ['8-16'],
                    'tuesday' => ['8-16'],
                    'wednesday' => ['8-16'],
                    'thursday' => ['8-16'],
                    'friday' => ['8-16']
                ],
                'efficiency' => [
                    'technical' => 0.9,
                    'customer_service' => 0.85
                ],
                'queues' => ['technical', 'customer_service']
            ],
            [
                'name' => 'Emma Davis',
                'availability' => [
                    'monday' => ['10-18'],
                    'tuesday' => ['10-18'],
                    'wednesday' => ['10-18'],
                    'thursday' => ['10-18'],
                    'friday' => ['10-18']
                ],
                'efficiency' => [
                    'customer_service' => 0.95,
                    'sales' => 0.8
                ],
                'queues' => ['customer_service', 'sales']
            ]
        ];

        foreach ($agents as $agentData) {
            $agent = new Agent();
            $agent->setName($agentData['name']);
            $agent->setAvailability($agentData['availability']);
            $agent->setEfficiency($agentData['efficiency']);

            foreach ($agentData['queues'] as $queueName) {
                $queue = $this->getReference('queue_' . $queueName, \App\Entity\Queue::class);
                $agent->addQueue($queue);
            }

            $manager->persist($agent);
            $this->addReference('agent_' . strtolower(str_replace(' ', '_', $agentData['name'])), $agent);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            QueueFixtures::class,
        ];
    }
} 