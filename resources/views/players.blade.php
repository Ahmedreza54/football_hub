
@extends('layouts.app')

@section('title', 'Players - Football Hub')

@section('content')

<!-- Page heading -->
<div class="text-center mb-5">
    <h1 class="display-5 fw-bold">Football Players</h1>
    <p class="lead text-secondary">
        Manage football players and their teams.
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

<!-- Add new player -->
<div class="card shadow-sm border-0 mb-5">
    <div class="card-header bg-primary text-white">
        <h2 class="h5 mb-0">Add New Player</h2>
    </div>

    <div class="card-body">
        <form action="{{ route('players.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <label for="name" class="form-label">Player Name</label>
                    <input type="text" id="name" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Enter player name"
                           value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-3">
                    <label for="position" class="form-label">Position</label>
                    <input type="text" id="position" name="position"
                           class="form-control @error('position') is-invalid @enderror"
                           placeholder="e.g. Forward"
                           value="{{ old('position') }}" required>
                    @error('position')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-3">
                    <label for="team_id" class="form-label">Team</label>
                    <select id="team_id" name="team_id"
                            class="form-select @error('team_id') is-invalid @enderror"
                            required>
                        <option value="">Select Team</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}"
                                {{ old('team_id') == $team->id ? 'selected' : '' }}>
                                {{ $team->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('team_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">
                        Add Player
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Players list -->
<h2 class="h4 mb-4">All Players</h2>

<div class="row g-4">
    @forelse($players as $player)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">

                    <h3 class="h5 card-title">
                        <a href="{{ route('players.show', $player) }}"
                           class="text-decoration-none fw-bold text-primary">
                            {{ $player->name }}
                        </a>
                    </h3>

                    <p class="mb-2">
                        <strong>Position:</strong> {{ $player->position }}
                    </p>

                    <p class="mb-3">
                        <strong>Team:</strong>
                        {{ $player->team->name ?? 'No team' }}
                    </p>

                    <!-- Delete player -->
                    <form
                        action="{{ route('players.destroy', $player) }}"
                        method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this player?');"
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger w-100">
                            Delete Player
                        </button>
                    </form>

                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <h3 class="h5">No players found</h3>
                <p class="mb-0">Add your first football player above.</p>
            </div>
        </div>
    @endforelse
</div>

@endsection
