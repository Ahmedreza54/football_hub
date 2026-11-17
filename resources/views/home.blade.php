
@extends('layouts.app')

@section('title', 'Home - Football Hub')

@section('content')

<!-- Welcome section -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body text-center py-5">
        <h1 class="fw-bold text-dark">Welcome to Football Hub</h1>
        <p class="text-secondary mb-0">
            Find football teams, players, matches and the latest football information.
        </p>
    </div>
</div>

<!-- Search section -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h2 class="h4 text-center mb-4">Search Football Hub</h2>

        <form action="{{ route('home') }}" method="GET"
              class="row g-2 justify-content-center">

            <div class="col-12 col-md-7">
                <input
                    type="search"
                    name="search"
                    class="form-control"
                    placeholder="Search for a team or player..."
                    value="{{ $search }}"
                    aria-label="Search teams and players">
            </div>

            <div class="col-6 col-md-auto">
                <button type="submit" class="btn btn-success w-100">
                    Search
                </button>
            </div>

            @if($search !== '')
                <div class="col-6 col-md-auto">
                    <a href="{{ route('home') }}"
                       class="btn btn-secondary w-100">
                        Clear Search
                    </a>
                </div>
            @endif
        </form>

        @if($search !== '')
            <h3 class="h5 mt-4">
                Search results for "{{ $search }}"
            </h3>

            @if($teamResults->isEmpty() && $playerResults->isEmpty())
                <div class="alert alert-warning mt-3">
                    No teams or players found. Please try another search.
                </div>
            @endif

            @foreach($teamResults as $team)
                <div class="alert alert-light border mt-3">
                    <strong>Team:</strong> {{ $team->name }}

                    @if($team->country)
                        — {{ $team->country }}
                    @endif

                    <div class="mt-2">
                        <a href="{{ route('teams') }}"
                           class="btn btn-sm btn-outline-primary">
                            View Teams
                        </a>
                    </div>
                </div>
            @endforeach

            @foreach($playerResults as $player)
                <div class="alert alert-light border mt-3">
                    <strong>Player:</strong>
                    {{ $player->name }} — {{ $player->position }}

                    @if($player->team)
                        <div class="small text-secondary mt-1">
                            Team: {{ $player->team->name }}
                        </div>
                    @endif

                    <div class="mt-2">
                        <a href="{{ route('players') }}"
                           class="btn btn-sm btn-outline-primary">
                            View Players
                        </a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<!-- Dashboard statistics -->
<h2 class="h3 text-center mb-4">Dashboard Statistics</h2>

<div class="row g-3 mb-5">

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card shadow-sm border-0 h-100 text-center">
            <div class="card-body">
                <h3 class="h6 text-secondary">Total Teams</h3>
                <p class="display-5 fw-bold text-success mb-0">
                    {{ $totalTeams }}
                </p>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card shadow-sm border-0 h-100 text-center">
            <div class="card-body">
                <h3 class="h6 text-secondary">Total Players</h3>
                <p class="display-5 fw-bold text-success mb-0">
                    {{ $totalPlayers }}
                </p>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card shadow-sm border-0 h-100 text-center">
            <div class="card-body">
                <h3 class="h6 text-secondary">Total Matches</h3>
                <p class="display-5 fw-bold text-success mb-0">
                    {{ $totalMatches }}
                </p>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card shadow-sm border-0 h-100 text-center">
            <div class="card-body">
                <h3 class="h6 text-secondary">Completed Matches</h3>
                <p class="display-5 fw-bold text-success mb-0">
                    {{ $completedMatches }}
                </p>
            </div>
        </div>
    </div>

</div>

<!-- Explore Football Hub -->
<h2 class="h3 text-center mb-4">Explore Football Hub</h2>

<div class="row g-3 mb-5">

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card shadow-sm border-0 h-100 text-center">
            <div class="card-body">
                <h3 class="h5 text-success">Teams</h3>
                <p>View football teams and their information.</p>
                <a href="{{ route('teams') }}" class="btn btn-outline-success">
                    View Teams
                </a>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card shadow-sm border-0 h-100 text-center">
            <div class="card-body">
                <h3 class="h5 text-success">Players</h3>
                <p>Explore football players and their details.</p>
                <a href="{{ route('players') }}" class="btn btn-outline-success">
                    View Players
                </a>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card shadow-sm border-0 h-100 text-center">
            <div class="card-body">
                <h3 class="h5 text-success">Matches</h3>
                <p>Check upcoming and previous football matches.</p>
                <a href="{{ route('matches') }}" class="btn btn-outline-success">
                    View Matches
                </a>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card shadow-sm border-0 h-100 text-center">
            <div class="card-body">
                <h3 class="h5 text-success">League Table</h3>
                <p>View team standings, points and goal difference.</p>
                <a href="{{ route('league-table') }}"
                   class="btn btn-outline-success">
                    View League Table
                </a>
            </div>
        </div>
    </div>

</div>

<!-- Football API fixtures -->
<section class="mb-5">

    @if(!$apiAvailable)

        <!-- API error message -->
        <div class="alert alert-warning text-center mb-4" role="alert">
            <h4 class="alert-heading">
                <i class="bi bi-exclamation-triangle"></i>
                Football Information Unavailable
            </h4>

            <p class="mb-0">
                {{ $apiError ?? 'Football information is temporarily unavailable. Please try again later.' }}
            </p>
        </div>

    @else

        <!-- Live matches -->
        <h2 class="h3 text-center mb-4">Live Matches</h2>

        @forelse($liveFixtures->take(5) as $fixture)

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <strong class="text-success">
                            {{ data_get($fixture, 'league.name', 'Football Match') }}
                        </strong>

                        <span class="badge bg-danger">LIVE</span>
                    </div>

                    <div class="row align-items-center text-center g-2">
                        <div class="col-4 fw-bold">
                            {{ data_get($fixture, 'teams.home.name', 'Home Team') }}
                        </div>

                        <div class="col-4 fs-4 fw-bold">
                            {{ data_get($fixture, 'goals.home', 0) }}
                            -
                            {{ data_get($fixture, 'goals.away', 0) }}
                        </div>

                        <div class="col-4 fw-bold">
                            {{ data_get($fixture, 'teams.away.name', 'Away Team') }}
                        </div>
                    </div>

                    <div class="text-center text-secondary small mt-3">
                        {{ data_get($fixture, 'fixture.status.long', 'In Progress') }}

                        @if(data_get($fixture, 'fixture.status.elapsed') !== null)
                            ({{ data_get($fixture, 'fixture.status.elapsed') }}')
                        @endif
                    </div>

                </div>
            </div>

        @empty

            <div class="alert alert-light border text-center">
                No live matches at the moment.
            </div>

        @endforelse

        <!-- Upcoming matches -->
        <h2 class="h3 text-center my-4">Upcoming Matches</h2>

        @forelse($upcomingFixtures->take(5) as $fixture)

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <strong class="text-success">
                            {{ data_get($fixture, 'league.name', 'Football Match') }}
                        </strong>

                        <span class="badge bg-primary">UPCOMING</span>
                    </div>

                    <div class="row align-items-center text-center g-2">
                        <div class="col-4 fw-bold">
                            {{ data_get($fixture, 'teams.home.name', 'Home Team') }}
                        </div>

                        <div class="col-4 fs-5 fw-bold">VS</div>

                        <div class="col-4 fw-bold">
                            {{ data_get($fixture, 'teams.away.name', 'Away Team') }}
                        </div>
                    </div>

                    <div class="text-center text-secondary small mt-3">
                        {{ \Illuminate\Support\Carbon::parse(data_get($fixture, 'fixture.date'))
                            ->setTimezone('Europe/London')
                            ->format('d M Y, H:i') }}
                    </div>

                </div>
            </div>

        @empty

            <div class="alert alert-light border text-center">
                No upcoming matches available today.
            </div>

        @endforelse

        <!-- Finished matches -->
        <h2 class="h3 text-center my-4">Finished Matches</h2>

        @forelse($finishedFixtures->take(5) as $fixture)

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <strong class="text-success">
                            {{ data_get($fixture, 'league.name', 'Football Match') }}
                        </strong>

                        <span class="badge bg-success">FT</span>
                    </div>

                    <div class="row align-items-center text-center g-2">
                        <div class="col-4 fw-bold">
                            {{ data_get($fixture, 'teams.home.name', 'Home Team') }}
                        </div>

                        <div class="col-4 fs-4 fw-bold">
                            {{ data_get($fixture, 'goals.home') }}
                            -
                            {{ data_get($fixture, 'goals.away') }}
                        </div>

                        <div class="col-4 fw-bold">
                            {{ data_get($fixture, 'teams.away.name', 'Away Team') }}
                        </div>
                    </div>

                    <div class="text-center text-secondary small mt-3">
                        {{ \Illuminate\Support\Carbon::parse(data_get($fixture, 'fixture.date'))
                            ->setTimezone('Europe/London')
                            ->format('d M Y, H:i') }}
                    </div>

                </div>
            </div>

        @empty

            <div class="alert alert-light border text-center">
                No finished matches available today.
            </div>

        @endforelse

    @endif

</section>

@endsection
