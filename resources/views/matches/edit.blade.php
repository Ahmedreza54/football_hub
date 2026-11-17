
@extends('layouts.app')

@section('title', 'Edit Match - Football Hub')

@section('content')

<div class="row justify-content-center">

    <div class="col-12 col-lg-8">

        <!-- Page heading -->
        <div class="text-center mb-4">
            <h1 class="fw-bold">Edit Match</h1>
            <p class="text-secondary">
                Update match information, date, venue and scores.
            </p>
        </div>

        <!-- Edit form -->
        <div class="card shadow-sm border-0">

            <div class="card-header bg-primary text-white">
                <h2 class="h5 mb-0">Match Details</h2>
            </div>

            <div class="card-body">

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

                <form action="{{ route('matches.update', $footballMatch->id) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    <!-- Home Team -->
                    <div class="mb-3">
                        <label for="home_team_id" class="form-label">
                            Home Team
                        </label>

                        <select
                            name="home_team_id"
                            id="home_team_id"
                            class="form-select @error('home_team_id') is-invalid @enderror"
                            required
                        >
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}"
                                    {{ old('home_team_id', $footballMatch->home_team_id) == $team->id ? 'selected' : '' }}>
                                    {{ $team->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('home_team_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Away Team -->
                    <div class="mb-3">
                        <label for="away_team_id" class="form-label">
                            Away Team
                        </label>

                        <select
                            name="away_team_id"
                            id="away_team_id"
                            class="form-select @error('away_team_id') is-invalid @enderror"
                            required
                        >
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}"
                                    {{ old('away_team_id', $footballMatch->away_team_id) == $team->id ? 'selected' : '' }}>
                                    {{ $team->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('away_team_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Match Date -->
                    <div class="mb-3">
                        <label for="match_date" class="form-label">
                            Match Date and Time
                        </label>

                        <input
                            type="datetime-local"
                            name="match_date"
                            id="match_date"
                            class="form-control @error('match_date') is-invalid @enderror"
                            value="{{ old('match_date', \Carbon\Carbon::parse($footballMatch->match_date)->format('Y-m-d\TH:i')) }}"
                            required
                        >

                        @error('match_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Venue -->
                    <div class="mb-3">
                        <label for="venue" class="form-label">Venue</label>

                        <input
                            type="text"
                            name="venue"
                            id="venue"
                            class="form-control @error('venue') is-invalid @enderror"
                            value="{{ old('venue', $footballMatch->venue) }}"
                            required
                        >

                        @error('venue')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <label for="status" class="form-label">Status</label>

                        <select
                            name="status"
                            id="status"
                            class="form-select @error('status') is-invalid @enderror"
                            required
                        >
                            @foreach(['Scheduled', 'Completed', 'Postponed', 'Cancelled'] as $status)
                                <option value="{{ $status }}"
                                    {{ old('status', $footballMatch->status) == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>

                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <!-- Match Scores -->
                    <h2 class="h5 mb-3">Match Scores</h2>

                    <div class="row g-3 mb-4">

                        <div class="col-12 col-md-6">
                            <label for="home_score" class="form-label">
                                Home Team Score
                            </label>

                            <input
                                type="number"
                                name="home_score"
                                id="home_score"
                                class="form-control @error('home_score') is-invalid @enderror"
                                min="0"
                                value="{{ old('home_score', $footballMatch->home_score) }}"
                                placeholder="Enter home team score"
                            >

                            @error('home_score')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="away_score" class="form-label">
                                Away Team Score
                            </label>

                            <input
                                type="number"
                                name="away_score"
                                id="away_score"
                                class="form-control @error('away_score') is-invalid @enderror"
                                min="0"
                                value="{{ old('away_score', $footballMatch->away_score) }}"
                                placeholder="Enter away team score"
                            >

                            @error('away_score')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="d-flex flex-wrap gap-2">

                        <button type="submit" class="btn btn-primary">
                            Save Changes
                        </button>

                        <a href="{{ route('matches') }}"
                           class="btn btn-secondary">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection
