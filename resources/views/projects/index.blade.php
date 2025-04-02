<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('projects.create') }}" class="btn btn-primary mb-3">Add New Project</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Team Members</th>
                                <th>Completed Jobs</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td>{{ $project->title }}</td>
                                    <td>{{ $project->description }}</td>
                                    <td>{{ $project->price }}</td>
                                    <td>{{ $project->start_date }}</td>
                                    <td>{{ $project->end_date }}</td>
                                    <td>
                                        @foreach ($project->members as $member)
                                            {{ $member->name }},
                                        @endforeach
                                    </td>
                                    <td>
                                        @php
                                            $completedJobs = [];
                                            foreach ($project->members as $member) {
                                                if ($member->pivot->job_completed) {
                                                    $completedJobs[] = $member->name . "'s job";
                                                }
                                            }
                                        @endphp
                                        {{ implode(', ', $completedJobs) }}
                                    </td>
                                    <td>
                                        @if ($project->user_id == $user->id)
                                            <!-- Edit and Delete buttons for project owners -->
                                            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this project?')">Delete</button>
                                            </form>
                                        @else
                                            <!-- Completed Job form for project members -->
                                            @if($project->members->contains($user))
                                                <form action="{{ route('projects.completeJob', $project->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" {{ $user->projects()->where('project_id', $project->id)->where('project_user.user_id', $user->id)->first()->pivot->job_completed ? 'disabled' : '' }}>
                                                        {{ $user->projects()->where('project_id', $project->id)->where('project_user.user_id', $user->id)->first()->pivot->job_completed ? 'Completed' : 'Complete Job' }}
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>