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
        NewsAggregate::factory(10)->create();
    }
}