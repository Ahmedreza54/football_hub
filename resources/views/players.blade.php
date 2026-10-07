<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Football Players</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                Football Hub
            </a>

            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('teams') }}">Teams</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('players') }}">Players</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('matches') }}">Matches</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>


    <!-- Page Header -->
    <div class="container py-5">

        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold">Football Players</h1>

            <p class="lead text-muted">
                Manage football players and their teams.
            </p>
        </div>


        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        <!-- Add Player -->
        <div class="card shadow-sm mb-5">

            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Add New Player</h3>
            </div>

            <div class="card-body">

                <form action="{{ route('players.store') }}" method="POST">

                    @csrf

                    <div class="row g-3">

                        <!-- Player Name -->
                        <div class="col-md-4">
                            <label class="form-label">
                                Player Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                placeholder="Enter player name"
                                required
                            >
                        </div>


                        <!-- Position -->
                        <div class="col-md-3">
                            <label class="form-label">
                                Position
                            </label>

                            <input
                                type="text"
                                name="position"
                                class="form-control"
                                placeholder="e.g. Forward"
                                required
                            >
                        </div>


                        <!-- Team -->
                        <div class="col-md-3">
                            <label class="form-label">
                                Team
                            </label>

                            <select name="team_id" class="form-select" required>

                                <option value="">
                                    Select Team
                                </option>

                                @foreach($teams as $team)

                                    <option value="{{ $team->id }}">
                                        {{ $team->name }}
                                    </option>

                                @endforeach

                            </select>
                        </div>


                        <!-- Button -->
                        <div class="col-md-2 d-flex align-items-end">

                            <button
                                type="submit"
                                class="btn btn-success w-100">
                                Add Player
                            </button>

                        </div>

                    </div>

                </form>

            </div>
        </div>


        <!-- Players -->
        <div class="row g-4">

            @forelse($players as $player)

                <div class="col-md-6 col-lg-4">

                    <div class="card shadow-sm h-100">

                        <div class="card-body text-center">

                            <h3 class="card-title text-primary">
                                {{ $player->name }}
                            </h3>

                            <p class="mb-2">
                                <strong>Position:</strong>
                                {{ $player->position }}
                            </p>

                            <p class="mb-3">
                                <strong>Team:</strong>

                                {{ $player->team->name ?? 'No team' }}
                            </p>


                            <!-- Delete -->
                            <form
                                action="{{ route('players.destroy', $player) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this player?');"
                            >

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger">
                                    Delete
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12">

                    <div class="alert alert-info text-center">
                        <h4>No players found</h4>

                        <p class="mb-0">
                            Add your first football player above.
                        </p>
                    </div>

                </div>

            @endforelse

        </div>

    </div>


    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>