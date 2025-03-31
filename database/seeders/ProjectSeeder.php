<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();

        Project::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);
    }
}
