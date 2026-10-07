<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Football Matches</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">

            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                Football Hub
            </a>

            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('home') }}">Home</a>
                <a class="nav-link" href="{{ route('teams') }}">Teams</a>
                <a class="nav-link" href="{{ route('players') }}">Players</a>
                <a class="nav-link active" href="{{ route('matches') }}">Matches</a>
            </div>

        </div>
    </nav>


    <!-- Main Content -->
    <div class="container py-5">

        <!-- Page Heading -->
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold">
                Football Matches
            </h1>

            <p class="lead text-muted">
                Manage football matches and their teams.
            </p>
        </div>


        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        <!-- Validation Errors -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <!-- Add New Match -->
        <div class="card shadow-sm mb-5">

            <div class="card-header bg-primary text-white">
                <h2 class="h4 mb-0">
                    Add New Match
                </h2>
            </div>

            <div class="card-body">

                <form action="{{ route('matches.store') }}" method="POST">

                    @csrf

                    <div class="row g-3">

                        <!-- Home Team -->
                        <div class="col-md-6">
                            <label for="home_team_id" class="form-label">
                                Home Team
                            </label>

                            <select
                                name="home_team_id"
                                id="home_team_id"
                                class="form-select"
                                required
                            >
                                <option value="">Select Home Team</option>

                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}">
                                        {{ $team->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>


                        <!-- Away Team -->
                        <div class="col-md-6">
                            <label for="away_team_id" class="form-label">
                                Away Team
                            </label>

                            <select
                                name="away_team_id"
                                id="away_team_id"
                                class="form-select"
                                required
                            >
                                <option value="">Select Away Team</option>

                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}">
                                        {{ $team->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>


                        <!-- Match Date -->
                        <div class="col-md-4">
                            <label for="match_date" class="form-label">
                                Match Date & Time
                            </label>

                            <input
                                type="datetime-local"
                                name="match_date"
                                id="match_date"
                                class="form-control"
                                required
                            >
                        </div>


                        <!-- Venue -->
                        <div class="col-md-4">
                            <label for="venue" class="form-label">
                                Venue
                            </label>

                            <input
                                type="text"
                                name="venue"
                                id="venue"
                                class="form-control"
                                placeholder="Enter venue"
                                required
                            >
                        </div>


                        <!-- Status -->
                        <div class="col-md-4">
                            <label for="status" class="form-label">
                                Status
                            </label>

                            <select
                                name="status"
                                id="status"
                                class="form-select"
                                required
                            >
                                <option value="Scheduled">
                                    Scheduled
                                </option>

                                <option value="Completed">
                                    Completed
                                </option>

                                <option value="Postponed">
                                    Postponed
                                </option>

                                <option value="Cancelled">
                                    Cancelled
                                </option>
                            </select>
                        </div>


                        <!-- Submit -->
                        <div class="col-12">
                            <button
                                type="submit"
                                class="btn btn-success"
                            >
                                Add Match
                            </button>
                        </div>

                    </div>

                </form>

            </div>
        </div>


        <!-- Matches List -->
        <div class="row g-4">

            @forelse($matches as $match)

                <div class="col-md-6 col-lg-4">

                    <div class="card shadow-sm h-100">

                        <div class="card-body text-center">

                            <h3 class="h5 text-primary fw-bold">
                                {{ $match->homeTeam->name }}
                                <span class="text-muted">vs</span>
                                {{ $match->awayTeam->name }}
                            </h3>

                            <hr>

                            <p class="mb-2">
                                <strong>Date:</strong>
                                {{ \Carbon\Carbon::parse($match->match_date)->format('d F Y') }}
                            </p>

                            <p class="mb-2">
                                <strong>Time:</strong>
                                {{ \Carbon\Carbon::parse($match->match_date)->format('H:i') }}
                            </p>

                            <p class="mb-2">
                                <strong>Venue:</strong>
                                {{ $match->venue }}
                            </p>

                            <p class="mb-3">
                                <strong>Status:</strong>

                                <span class="badge
                                    @if($match->status === 'Completed')
                                        bg-success
                                    @elseif($match->status === 'Cancelled')
                                        bg-danger
                                    @elseif($match->status === 'Postponed')
                                        bg-warning text-dark
                                    @else
                                        bg-primary
                                    @endif
                                ">
                                    {{ $match->status }}
                                </span>
                            </p>


                            <!-- Delete Match -->
                            <form
                                action="{{ route('matches.destroy', $match) }}"
                                method="POST"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this match?')"
                                >
                                    Delete
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12">

                    <div class="alert alert-info text-center">
                        No matches have been added yet.
                    </div>

                </div>

            @endforelse

        </div>

    </div>

</body>
</html>