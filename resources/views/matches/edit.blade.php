
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Match - Football Hub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">Football Hub</a>
        <a href="{{ route('matches') }}" class="btn btn-outline-light">Back to Matches</a>
    </div>
</nav>

<div class="container">
    <div class="card shadow-sm mx-auto" style="max-width: 700px;">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Match</h4>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('matches.update', $footballMatch->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Home Team</label>
                    <select name="home_team_id" class="form-select" required>
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}"
                                {{ old('home_team_id', $footballMatch->home_team_id) == $team->id ? 'selected' : '' }}>
                                {{ $team->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Away Team</label>
                    <select name="away_team_id" class="form-select" required>
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}"
                                {{ old('away_team_id', $footballMatch->away_team_id) == $team->id ? 'selected' : '' }}>
                                {{ $team->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Match Date and Time</label>
                    <input type="datetime-local"
                           name="match_date"
                           class="form-control"
                           value="{{ old('match_date', \Carbon\Carbon::parse($footballMatch->match_date)->format('Y-m-d\TH:i')) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Venue</label>
                    <input type="text"
                           name="venue"
                           class="form-control"
                           value="{{ old('venue', $footballMatch->venue) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        @foreach (['Scheduled', 'Completed', 'Postponed', 'Cancelled'] as $status)
                            <option value="{{ $status }}"
                                {{ old('status', $footballMatch->status) == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('matches') }}" class="btn btn-secondary">Cancel</a>
            </form>

        </div>
    </div>
</div>

</body>
</html>
