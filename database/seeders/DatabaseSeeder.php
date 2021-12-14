<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        if(count(Category::all()) == 0){
            Category::create([
                'title' => 'Sports & Active Life',
                'description' => 'Games, tournaments and more.'
            ]);
            Category::create([
                'title' => 'Performing Arts',
                'description' => 'Plays, exhibits, and creative events.'
            ]);
            Category::create([
                'title' => 'Conference',
                'description' => 'Conferences gather large groups of people, often for several days, and can majorly impact demand.'
            ]);
            Category::create([
                'title' => 'Expo',
                'description' => 'Art, business, technology to food - there is too many expos to list that could impact your business.'
            ]);
            Category::create([
                'title' => 'Concert',
                'description' => 'Whether it is a sold-out stadium show or an open mic at a bar, musical performances always draw crowds.'
            ]);
            Category::create([
                'title' => 'Festival',
                'description' => 'Festivals vary in size and location and can be hard to track.'
            ]);
            Category::create([
                'title' => 'Community',
                'description' => 'There are thousands of community events of varying impact every week.'
            ]);
            Category::create([
                'title' => 'Academic',
                'description' => 'Graduations, exam time and spring break.'
            ]);
        }
    }
}
