
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Football Matches - Football Hub</title>

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
                Manage football matches, scores and results.
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
                                    <option
                                        value="{{ $team->id }}"
                                        {{ old('home_team_id') == $team->id ? 'selected' : '' }}
                                    >
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
                                    <option
                                        value="{{ $team->id }}"
                                        {{ old('away_team_id') == $team->id ? 'selected' : '' }}
                                    >
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
                                value="{{ old('match_date') }}"
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
                                value="{{ old('venue') }}"
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
                                @foreach(['Scheduled', 'Completed', 'Postponed', 'Cancelled'] as $status)
                                    <option
                                        value="{{ $status }}"
                                        {{ old('status', 'Scheduled') == $status ? 'selected' : '' }}
                                    >
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Home Team Score -->
                        <div class="col-md-6">
                            <label for="home_score" class="form-label">
                                Home Team Score
                            </label>

                            <input
                                type="number"
                                name="home_score"
                                id="home_score"
                                class="form-control"
                                min="0"
                                value="{{ old('home_score') }}"
                                placeholder="Enter home team score"
                            >
                        </div>

                        <!-- Away Team Score -->
                        <div class="col-md-6">
                            <label for="away_score" class="form-label">
                                Away Team Score
                            </label>

                            <input
                                type="number"
                                name="away_score"
                                id="away_score"
                                class="form-control"
                                min="0"
                                value="{{ old('away_score') }}"
                                placeholder="Enter away team score"
                            >
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

                            <!-- Teams -->
                            <h3 class="h5 text-primary fw-bold">
                                {{ $match->homeTeam->name }}
                                <span class="text-muted">vs</span>
                                {{ $match->awayTeam->name }}
                            </h3>

                            <!-- Match Score -->
                            @if($match->home_score !== null && $match->away_score !== null)

                                <h2 class="fw-bold text-success my-3">
                                    {{ $match->home_score }}
                                    -
                                    {{ $match->away_score }}
                                </h2>

                            @else

                                <p class="text-muted my-3">
                                    Score not available yet
                                </p>

                            @endif

                            <hr>

                            <!-- Date -->
                            <p class="mb-2">
                                <strong>Date:</strong>
                                {{ \Carbon\Carbon::parse($match->match_date)->format('d F Y') }}
                            </p>

                            <!-- Time -->
                            <p class="mb-2">
                                <strong>Time:</strong>
                                {{ \Carbon\Carbon::parse($match->match_date)->format('H:i') }}
                            </p>

                            <!-- Venue -->
                            <p class="mb-2">
                                <strong>Venue:</strong>
                                {{ $match->venue }}
                            </p>

                            <!-- Status -->
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

                            <!-- Edit and Delete Buttons -->
                            <div class="d-flex justify-content-center gap-2">

                                <a
                                    href="{{ route('matches.edit', $match) }}"
                                    class="btn btn-primary btn-sm"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('matches.destroy', $match) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this match?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                    >
                                        Delete
                                    </button>
                                </form>

                            </div>

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
