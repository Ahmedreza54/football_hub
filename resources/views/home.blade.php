
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

<!-- AJAX Search section -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h2 class="h4 text-center mb-4">Search Football Hub</h2>

        <form id="dashboardSearchForm"
              class="row g-2 justify-content-center">

            <div class="col-12 col-md-7">
                <input
                    type="search"
                    id="dashboardSearchInput"
                    class="form-control"
                    placeholder="Search for a team or player..."
                    value="{{ $search }}"
                    aria-label="Search teams and players"
                    autocomplete="off">
            </div>

            <div class="col-6 col-md-auto">
                <button type="submit" class="btn btn-success w-100">
                    Search
                </button>
            </div>

            <div class="col-6 col-md-auto">
                <button type="button"
                        id="clearDashboardSearch"
                        class="btn btn-secondary w-100">
                    Clear Search
                </button>
            </div>
        </form>

        <div id="dashboardSearchLoading"
             class="text-center text-secondary mt-3 d-none"
             role="status">
            Searching...
        </div>

        <div id="dashboardSearchResults"
             class="mt-3"
             aria-live="polite">

            {{-- Server-rendered results remain available if JavaScript is disabled --}}
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

<!-- Find nearby football grounds using Geolocation API -->
<div class="card shadow-sm border-0 mb-5">
    <div class="card-body text-center p-4">

        <h2 class="h4 mb-3">Find Football Grounds Near Me</h2>

        <p class="text-secondary">
            Use your device location to find nearby football grounds.
        </p>

        <button
            type="button"
            id="findGroundsButton"
            class="btn btn-success w-100">
            Find Nearby Football Grounds
        </button>

        <div
            id="locationMessage"
            class="mt-3"
            role="status"
            aria-live="polite">
        </div>

        <div id="mapsResult" class="mt-3 d-none">
            <a
                id="mapsLink"
                href="#"
                target="_blank"
                rel="noopener noreferrer"
                class="btn btn-outline-primary">
                Open Nearby Football Grounds in Google Maps
            </a>
        </div>

    </div>
</div>

<!-- Football API fixtures -->
<section class="mb-5">

    @if(!$apiAvailable)

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

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // AJAX / FETCH LIVE DASHBOARD SEARCH
    // ==========================================

    const searchForm = document.getElementById('dashboardSearchForm');
    const searchInput = document.getElementById('dashboardSearchInput');
    const searchResults = document.getElementById('dashboardSearchResults');
    const loadingMessage = document.getElementById('dashboardSearchLoading');
    const clearButton = document.getElementById('clearDashboardSearch');

    let searchTimer;
    let currentController = null;

    // Safely create an HTML element with text
    function createTextElement(tag, text, className = '') {
        const element = document.createElement(tag);
        element.textContent = text ?? '';

        if (className) {
            element.className = className;
        }

        return element;
    }

    // Display search results
    function displaySearchResults(data, searchTerm) {

        searchResults.replaceChildren();

        const teams = data.teams || [];
        const players = data.players || [];

        const heading = createTextElement(
            'h3',
            'Search results for "' + searchTerm + '"',
            'h5 mt-4'
        );

        searchResults.appendChild(heading);

        if (teams.length === 0 && players.length === 0) {
            const message = createTextElement(
                'div',
                'No teams or players found. Please try another search.',
                'alert alert-warning mt-3'
            );

            searchResults.appendChild(message);
            return;
        }

        // Display matching teams
        teams.forEach(function (team) {

            const card = createTextElement(
                'div',
                '',
                'alert alert-light border mt-3'
            );

            const title = createTextElement(
                'strong',
                'Team: ' + team.name
            );

            card.appendChild(title);

            if (team.country) {
                card.appendChild(
                    document.createTextNode(' — ' + team.country)
                );
            }

            const buttonContainer = createTextElement(
                'div',
                '',
                'mt-2'
            );

            const link = createTextElement(
                'a',
                'View Teams',
                'btn btn-sm btn-outline-primary'
            );

            link.href = @json(route('teams'));

            buttonContainer.appendChild(link);
            card.appendChild(buttonContainer);
            searchResults.appendChild(card);
        });

        // Display matching players
        players.forEach(function (player) {

            const card = createTextElement(
                'div',
                '',
                'alert alert-light border mt-3'
            );

            const title = createTextElement(
                'strong',
                'Player: '
            );

            card.appendChild(title);

            card.appendChild(
                document.createTextNode(
                    player.name + ' — ' + (player.position || '')
                )
            );

            if (player.team) {
                const teamInfo = createTextElement(
                    'div',
                    'Team: ' + player.team,
                    'small text-secondary mt-1'
                );

                card.appendChild(teamInfo);
            }

            const buttonContainer = createTextElement(
                'div',
                '',
                'mt-2'
            );

            const link = createTextElement(
                'a',
                'View Players',
                'btn btn-sm btn-outline-primary'
            );

            link.href = @json(route('players'));

            buttonContainer.appendChild(link);
            card.appendChild(buttonContainer);
            searchResults.appendChild(card);
        });
    }

    // Send search request using Fetch API
    async function performSearch() {

        const searchTerm = searchInput.value.trim();

        // Cancel any previous request
        if (currentController) {
            currentController.abort();
        }

        if (searchTerm === '') {
            searchResults.replaceChildren();
            loadingMessage.classList.add('d-none');
            return;
        }

        currentController = new AbortController();

        loadingMessage.classList.remove('d-none');

        try {

            const url = new URL(
                @json(route('home')),
                window.location.origin
            );

            url.searchParams.set('search', searchTerm);

            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                signal: currentController.signal
            });

            if (!response.ok) {
                throw new Error('Search request failed.');
            }

            const data = await response.json();

            // Do not display outdated search results
            if (searchInput.value.trim() === searchTerm) {
                displaySearchResults(data, searchTerm);
            }

        } catch (error) {

            if (error.name !== 'AbortError') {
                searchResults.replaceChildren();

                const message = createTextElement(
                    'div',
                    'Something went wrong. Please try searching again.',
                    'alert alert-danger mt-3'
                );

                searchResults.appendChild(message);
            }

        } finally {
            loadingMessage.classList.add('d-none');
        }
    }

    // Search automatically while typing
    searchInput.addEventListener('input', function () {

        clearTimeout(searchTimer);

        searchTimer = setTimeout(function () {
            performSearch();
        }, 300);
    });

    // Handle Search button
    searchForm.addEventListener('submit', function (event) {

        event.preventDefault();

        clearTimeout(searchTimer);
        performSearch();
    });

    // Clear search
    clearButton.addEventListener('click', function () {

        clearTimeout(searchTimer);

        if (currentController) {
            currentController.abort();
        }

        searchInput.value = '';
        searchResults.replaceChildren();
        loadingMessage.classList.add('d-none');

        searchInput.focus();

        const url = new URL(window.location.href);
        url.searchParams.delete('search');

        window.history.replaceState({}, '', url);
    });

    // ==========================================
    // FIND NEARBY FOOTBALL GROUNDS
    // ==========================================

    const findButton = document.getElementById('findGroundsButton');
    const locationMessage = document.getElementById('locationMessage');
    const mapsResult = document.getElementById('mapsResult');
    const mapsLink = document.getElementById('mapsLink');

    findButton.addEventListener('click', function () {

        mapsResult.classList.add('d-none');

        if (!navigator.geolocation) {
            locationMessage.textContent =
                'Your browser does not support location services.';
            return;
        }

        findButton.disabled = true;
        findButton.textContent = 'Getting your location...';

        locationMessage.textContent =
            'Please allow location access when your browser asks.';

        navigator.geolocation.getCurrentPosition(

            function (position) {

                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                const mapsUrl =
                    'https://www.google.com/maps/search/football+grounds/@' +
                    latitude + ',' + longitude + ',14z';

                mapsLink.href = mapsUrl;
                mapsResult.classList.remove('d-none');

                locationMessage.textContent =
                    'Your location was found successfully.';

                findButton.disabled = false;
                findButton.textContent =
                    'Find Nearby Football Grounds';
            },

            function (error) {

                let message = 'Unable to get your location.';

                if (error.code === error.PERMISSION_DENIED) {
                    message =
                        'Location permission was denied. Please allow location access in your browser settings.';
                } else if (error.code === error.POSITION_UNAVAILABLE) {
                    message =
                        'Your current location is unavailable.';
                } else if (error.code === error.TIMEOUT) {
                    message =
                        'Location request timed out. Please try again.';
                }

                locationMessage.textContent = message;

                findButton.disabled = false;
                findButton.textContent = 'Try Again';
            },

            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 60000
            }
        );
    });

});
</script>
@endsection
