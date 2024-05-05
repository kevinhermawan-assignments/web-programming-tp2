<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Project $project)
    {
        $backlogTasks = Task::where('project_id', $project->id)->where('status', 'backlog')->orderByDesc('created_at')->get();
        $ongoingTasks = Task::where('project_id', $project->id)->where('status', 'ongoing')->orderByDesc('created_at')->get();
        $availableTasks = $backlogTasks->merge($backlogTasks)->merge($ongoingTasks);
        $completedTasks = Task::where('project_id', $project->id)->where('status', 'completed')->orderByDesc('created_at')->get();

        return view('tasks.index', [
            'project' => $project,
            'backlogTasks' => $backlogTasks,
            'ongoingTasks' => $ongoingTasks,
            'availableTasks' => $availableTasks,
            'completedTasks' => $completedTasks
        ]);
    }

    public function store(Request $request, Project $project)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $project->tasks()->create($validatedData);

        return redirect()->route('tasks.index', $project)->with('success', 'Task added successfully!');
    }

    public function update(Request $request, Project $project, Task $task)
    {
        $validatedData = $request->validate([
            'status' => 'required|string'
        ]);

        $task->update($validatedData);

        return redirect()->route('tasks.index', $project)->with('success', 'Task updated successfully!');
    }

    public function destroy(Project $project, Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index', $project)->with('success', 'Task deleted successfully!');
    }
}
