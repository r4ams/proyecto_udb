<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Project;

class TaskSeeder extends Seeder
{
    public function run()
    {
        $projects = Project::all();

        foreach ($projects as $project) {
            Task::factory()->count(5)->create([
                'project_id' => $project->id,
            ]);
        }
    }
}
