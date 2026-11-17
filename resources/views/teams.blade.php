
@extends('layouts.app')

@section('title', 'Teams - Football Hub')

@section('content')

<!-- Page heading -->
<div class="text-center mb-5">
    <h1 class="fw-bold">Football Teams</h1>
    <p class="text-secondary">
        Explore football teams and their information.
    </p>
</div>

<!-- Success message -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}

        <button type="button" class="btn-close"
                data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Validation errors -->
@if($errors->any())
    <div class="alert alert-danger">
        <strong>Please correct the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Add new team -->
<div class="card shadow-sm border-0 mb-5">

    <div class="card-header bg-primary text-white">
        <h2 class="h5 mb-0">Add New Team</h2>
    </div>

    <div class="card-body">

        <form action="{{ route('teams.store') }}" method="POST">
            @csrf

            <div class="row g-3">

                <div class="col-12 col-md-5">
                    <label for="name" class="form-label">Team Name</label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Enter team name"
                        value="{{ old('name') }}"
                        required
                    >

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-5">
                    <label for="country" class="form-label">Country</label>

                    <input
                        type="text"
                        id="country"
                        name="country"
                        class="form-control @error('country') is-invalid @enderror"
                        placeholder="Enter country"
                        value="{{ old('country') }}"
                        required
                    >

                    @error('country')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">
                        Add Team
                    </button>
                </div>

            </div>
        </form>

    </div>
</div>

<!-- Display teams -->
<h2 class="h4 mb-4">All Teams</h2>

<div class="row g-4">

    @forelse($teams as $team)

        <div class="col-12 col-md-6 col-lg-4">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body text-center">

                    <h3 class="h5 card-title text-primary">
                        {{ $team->name }}
                    </h3>

                    <p class="card-text text-secondary">
                        <strong>Country:</strong> {{ $team->country }}
                    </p>

                    <form
                        action="{{ route('teams.destroy', $team) }}"
                        method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this team?')"
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">
                            Delete Team
                        </button>
                    </form>

                </div>
            </div>

        </div>

    @empty

        <div class="col-12">
            <div class="alert alert-info text-center">
                <h3 class="h5">No teams found</h3>
                <p class="mb-0">
                    Add your first football team using the form above.
                </p>
            </div>
        </div>

    @endforelse

</div>

@endsection
