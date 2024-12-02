<?php

namespace Database\Seeders;

use App\Models\NewsAggregate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NewsAggregateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!NewsAggregate::count()){
            NewsAggregate::factory(100)->create();
        }
    }
}
