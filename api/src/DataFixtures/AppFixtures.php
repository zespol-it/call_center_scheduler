<?php

namespace App\DataFixtures;

use App\Entity\Agent;
use App\Entity\Queue;
use App\Entity\Shift;
use App\Entity\DemandForecast;
use App\Entity\ScheduleRequest;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Create Queues
        $queues = [];
        $queueNames = ['Sales', 'Support', 'Technical', 'Customer Service'];
        foreach ($queueNames as $name) {
            $queue = new Queue();
            $queue->setName($name);
            $manager->persist($queue);
            $queues[] = $queue;
        }

        // Create Agents
        $agents = [];
        $agentNames = ['John Smith', 'Jane Doe', 'Mike Johnson', 'Sarah Wilson', 'Robert Brown'];
        foreach ($agentNames as $name) {
            $agent = new Agent();
            $agent->setName($name);
            
            // Random efficiency for each queue (70-100%)
            $efficiency = [];
            foreach ($queues as $queue) {
                $efficiency[$queue->getName()] = rand(70, 100);
            }
            $agent->setEfficiency($efficiency);
            
            // Random availability (0-1 for each hour)
            $availability = [];
            for ($day = 0; $day < 7; $day++) {
                for ($hour = 8; $hour < 20; $hour++) {
                    $availability["{$day}-{$hour}"] = (rand(0, 100) > 30) ? 1 : 0;
                }
            }
            $agent->setAvailability($availability);
            
            // Assign random queues (1-3 queues per agent)
            $numQueues = rand(1, 3);
            $shuffledQueues = $queues;
            shuffle($shuffledQueues);
            for ($i = 0; $i < $numQueues; $i++) {
                $agent->addQueue($shuffledQueues[$i]);
            }
            
            $manager->persist($agent);
            $agents[] = $agent;
        }

        // Create Shifts (for next 7 days)
        $startDate = new DateTime();
        for ($day = 0; $day < 7; $day++) {
            foreach ($agents as $agent) {
                if (rand(0, 100) > 30) { // 70% chance to have a shift
                    $shift = new Shift();
                    $shift->setAgent($agent);
                    $shift->setQueue($agent->getQueues()[0]); // Assign to first queue
                    
                    $startTime = clone $startDate;
                    $startTime->modify("+{$day} days");
                    $startTime->setTime(rand(8, 12), 0); // Start between 8-12
                    
                    $endTime = clone $startTime;
                    $endTime->modify('+8 hours'); // 8-hour shifts
                    
                    $shift->setStartTime($startTime);
                    $shift->setEndTime($endTime);
                    
                    $manager->persist($shift);
                }
            }
        }

        // Create DemandForecasts (for next 7 days)
        $startDate = new DateTime();
        foreach ($queues as $queue) {
            for ($day = 0; $day < 7; $day++) {
                for ($hour = 8; $hour < 20; $hour++) {
                    $forecast = new DemandForecast();
                    $forecast->setQueue($queue);
                    
                    $timestamp = clone $startDate;
                    $timestamp->modify("+{$day} days");
                    $timestamp->setTime($hour, 0);
                    
                    $forecast->setTimestamp($timestamp);
                    $forecast->setExpectedCalls(rand(10, 50)); // Random number of expected calls
                    
                    $manager->persist($forecast);
                }
            }
        }

        // Create ScheduleRequest
        $request = new ScheduleRequest();
        $request->setStartDate($startDate);
        $endDate = clone $startDate;
        $endDate->modify('+7 days');
        $request->setEndDate($endDate);
        $request->setStatus('completed');
        $request->setResult(['status' => 'success', 'message' => 'Schedule generated successfully']);
        $manager->persist($request);

        $manager->flush();
    }
}
