<?php

namespace App\DataFixtures;

use App\Entity\Queue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QueueFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $queues = [
            ['name' => 'Sales'],
            ['name' => 'Support'],
            ['name' => 'Technical'],
            ['name' => 'Customer Service']
        ];

        foreach ($queues as $queueData) {
            $queue = new Queue();
            $queue->setName($queueData['name']);
            $manager->persist($queue);
            $this->addReference('queue_' . strtolower(str_replace(' ', '_', $queueData['name'])), $queue);
        }

        $manager->flush();
    }
} 