<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dodaj novi projekt') }}
        </h2>
    </x-slot>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Dodaj novi projekt
                    </div>
                    <div class="card-body">
                        <!-- Show errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('projects.store') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="title" class="form-label">Naziv projekta</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Opis projekta</label>
                                <textarea name="description" id="description" class="form-control" required>{{ old('description') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Cijena projekta</label>
                                <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="start_date" class="form-label">Datum početka</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="end_date" class="form-label">Datum završetka</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Dodaj projekt
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
