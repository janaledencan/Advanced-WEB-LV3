<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Models\Project;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\SUpport\Facades\Auth;

class ProjectController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return ['auth'];
    }

    public function index()
    {
        $projects = Project::with('members')->get(); // Load the members relationship
        $user = Auth::user(); //Getting authenticated user
        return view('projects.index', compact('projects', 'user'));
    }

    public function create()
    {
        $users = User::all(); // Fetch all users
        return view('projects.create', compact('users')); // Pass users to the view
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'team_members' => 'nullable|array', // Validate team_members as an array
            'team_members.*' => 'exists:users,id', // Ensure each team member ID exists in the users table
        ]);

        $project = Project::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        // Attach team members to the project
        if ($request->has('team_members')) {
            $project->members()->attach($request->team_members);
        }

        return redirect()->route('projects.index')->with('success', 'Projekt uspješno dodan!');
    }

    public function edit(Project $project)
    {
        $users = User::all();
        return view('projects.edit', compact('project', 'users'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'team_members' => 'nullable|array',
            'team_members.*' => 'exists:users,id',
        ]);

        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'completed_jobs' => $request->input('completed_jobs', 0), 
        ]);

        // Sync team members
        $project->members()->sync($request->input('team_members', []));

        return redirect()->route('projects.index')->with('success', 'Project updated successfully!');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully!');
    }

    public function completeJob(Project $project)
    {
        $user = Auth::user();

        // Check if the user is a member of the project
        if ($project->members()->where('users.id', $user->id)->exists()) {
            // Toggle the job_completed status
            $project->members()->updateExistingPivot($user->id, [
                'job_completed' => true,
            ]);
        }

        return redirect()->route('projects.index')->with('success', 'Project job completed!');
    }
}
