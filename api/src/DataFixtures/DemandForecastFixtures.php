<?php

namespace App\DataFixtures;

use App\Entity\DemandForecast;
use App\Entity\Queue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DemandForecastFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $forecasts = [
            ['queue' => 'sales', 'timestamp' => '2024-04-12 09:00:00', 'expected_calls' => 25],
            ['queue' => 'sales', 'timestamp' => '2024-04-12 14:00:00', 'expected_calls' => 35],
            ['queue' => 'support', 'timestamp' => '2024-04-12 10:00:00', 'expected_calls' => 40],
            ['queue' => 'support', 'timestamp' => '2024-04-12 15:00:00', 'expected_calls' => 30],
            ['queue' => 'technical', 'timestamp' => '2024-04-12 11:00:00', 'expected_calls' => 20],
            ['queue' => 'technical', 'timestamp' => '2024-04-12 16:00:00', 'expected_calls' => 15],
            ['queue' => 'customer_service', 'timestamp' => '2024-04-12 12:00:00', 'expected_calls' => 45],
            ['queue' => 'customer_service', 'timestamp' => '2024-04-12 17:00:00', 'expected_calls' => 25]
        ];

        foreach ($forecasts as $forecastData) {
            $forecast = new DemandForecast();
            $forecast->setQueue($this->getReference('queue_' . $forecastData['queue'], Queue::class));
            $forecast->setTimestamp(new \DateTime($forecastData['timestamp']));
            $forecast->setExpectedCalls($forecastData['expected_calls']);
            $manager->persist($forecast);
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