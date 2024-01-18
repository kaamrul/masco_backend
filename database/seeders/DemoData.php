<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\DemoData\TicketSeeder;
use Database\Seeders\DemoData\EmployeeSeeder;
use Database\Seeders\DemoData\LocationSeeder;
use Database\Seeders\DemoData\NotificationSeeder;

class DemoData extends Seeder
{
    public function run()
    {
        $this->call([
            LocationSeeder::class,
            NotificationSeeder::class,
            EmployeeSeeder::class,
            TicketSeeder::class,
        ]);
    }
}
