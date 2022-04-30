<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $user = User::factory()->create([
            'email' => 'johndoe@mailinator.com',
        ]);

        $school = Collection::factory()->create([
            'user_id' => $user->id,
            'title' => 'School',
            'color' => '#F6769F'
        ]);

        Task::factory()->count(8)->create([
            'collection_id' => $school->id,
        ]);

        $personal = Collection::factory()->create([
            'user_id' => $user->id,
            'title' => 'Personal',
            'color' => '#69C3BA'
        ]);

        Task::factory()->count(5)->create([
            'collection_id' => $personal->id,
        ]);

        $design = Collection::factory()->create([
            'user_id' => $user->id,
            'title' => 'Design',
            'color' => '#B06EE2'
        ]);

        Task::factory()->count(15)->create([
            'collection_id' => $design->id,
        ]);

        $groceries = Collection::factory()->create([
            'user_id' => $user->id,
            'title' => 'Groceries',
            'color' => '#D1AF4D'
        ]);

        Task::factory()->count(10)->create([
            'collection_id' => $groceries->id,
        ]);
    }
}
