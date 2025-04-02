<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

             <!-- Projects created by user -->
             <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">
                    {{ __('Projects Created By Me') }}
                </h3>

                <ul>
                    @forelse ($createdProjects as $project)
                        <li>{{ $project->title }}</li>
                    @empty
                        <li>{{ __('No projects created yet.') }}</li>
                    @endforelse
                </ul>
            </div>

            <!-- Projects where user is a member -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">
                    {{ __('Projects I Am A Member Of') }}
                </h3>

                <ul>
                    @forelse ($memberProjects as $project)
                        <li>{{ $project->title }}</li>
                    @empty
                        <li>{{ __('Not a member of any projects yet.') }}</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
