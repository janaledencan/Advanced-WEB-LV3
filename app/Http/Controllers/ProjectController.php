<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Models\Project;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProjectController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return ['auth'];
    }

    public function index()
    {
        $projects = Project::with('members')->get(); // Load the members relationship
        return view('projects.index', compact('projects'));
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

        return redirect()->route('dashboard')->with('success', 'Projekt uspješno dodan!');
    }
}
