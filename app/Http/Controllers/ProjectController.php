<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->projects()->latest()->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string'
        ]);

        return $request->user()->projects()->create($data);
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);
        return $project;
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $project->update($request->only(['name', 'description']));
        return $project;
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();

        return response()->noContent();
    }
}
