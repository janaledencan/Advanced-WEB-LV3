<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Project') }}
        </h2>
    </x-slot>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Edit Project
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('projects.update', $project->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">Project Title</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $project->title) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Project Description</label>
                                <textarea name="description" id="description" class="form-control" required>{{ old('description', $project->description) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Project Price</label>
                                <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $project->price) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $project->start_date) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $project->end_date) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Team Members</label>
                                @foreach ($users as $user)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="team_members[]" value="{{ $user->id }}" id="user_{{ $user->id }}"
                                            @if(in_array($user->id, $project->members->pluck('id')->toArray())) checked @endif>
                                        <label class="form-check-label" for="user_{{ $user->id }}">
                                            {{ $user->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mb-3 form-check">
                                <input type="hidden" name="completed_jobs" value="0">
                                <input type="checkbox" class="form-check-input" id="completed_jobs" name="completed_jobs" value="1" 
                                {{ old('completed_jobs', $project->completed_jobs) ? "checked" : "" }}>

                                <label class="form-check-label" for="completed_jobs">Completed Job</label>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Update Project
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
