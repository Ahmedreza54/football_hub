
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Football Hub</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #111827;
            color: white;
            padding: 20px;
            text-align: center;
        }

        nav {
            background-color: #1f2937;
            padding: 12px;
            text-align: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }

        nav a:hover {
            color: #22c55e;
        }

        .container {
            width: 90%;
            max-width: 1100px;
            margin: 30px auto;
        }

        .welcome {
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
        }

        .welcome h2 {
            color: #111827;
        }

        .section-title {
            text-align: center;
            color: #111827;
            margin-top: 35px;
            margin-bottom: 20px;
        }

        /* Dashboard statistics */

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 25px;
        }

        .stat-card {
            background: white;
            padding: 25px 15px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            border-bottom: 4px solid #16a34a;
        }

        .stat-card h3 {
            color: #555;
            font-size: 16px;
            margin-bottom: 12px;
        }

        .stat-number {
            color: #111827;
            font-size: 32px;
            font-weight: bold;
            margin: 0;
        }

        /* Navigation cards */

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 25px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
        }

        .card h3 {
            color: #16a34a;
        }

        .card a {
            color: #2563eb;
            font-weight: bold;
            text-decoration: none;
        }

        .card a:hover {
            color: #16a34a;
            text-decoration: underline;
        }

        /* Football fixtures */

        .fixtures-section {
            margin-top: 35px;
        }

        .fixtures-section h2 {
            text-align: center;
            color: #111827;
            margin-top: 35px;
            margin-bottom: 20px;
        }

        .fixture-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .fixture-league {
            color: #16a34a;
            font-weight: bold;
            margin-bottom: 12px;
        }

        .fixture-teams {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            text-align: center;
        }

        .team-name {
            flex: 1;
            font-weight: bold;
        }

        .fixture-score {
            font-size: 22px;
            font-weight: bold;
            color: #111827;
            white-space: nowrap;
        }

        .fixture-status {
            text-align: center;
            margin-top: 12px;
            color: #555;
            font-size: 14px;
        }

        /* Match status badges */

        .match-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 11px;
            margin-left: 8px;
            color: white;
        }

        .live-badge {
            background: #dc2626;
        }

        .upcoming-badge {
            background: #2563eb;
        }

        .finished-badge {
            background: #16a34a;
        }

        .empty-message {
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            color: #666;
        }

        footer {
            text-align: center;
            color: #666;
            padding: 25px;
            margin-top: 30px;
        }

        /* Responsive design */

        @media (max-width: 900px) {
            .stats-grid,
            .cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .stats-grid,
            .cards {
                grid-template-columns: 1fr;
            }

            nav a {
                display: inline-block;
                margin: 7px;
            }

            .fixture-teams {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

    <header>
        <h1>Football Hub</h1>
        <p>Your football information website</p>
    </header>

    <nav>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('teams') }}">Teams</a>
        <a href="{{ route('players') }}">Players</a>
        <a href="{{ route('matches') }}">Matches</a>
        <a href="{{ route('league-table') }}">League Table</a>
        <a href="#">News</a>
    </nav>

    <div class="container">

        <!-- Welcome section -->

        <div class="welcome">
            <h2>Welcome to Football Hub</h2>
            <p>
                Find football teams, players, matches and the latest football information.
            </p>
        </div>

        <!-- Dashboard statistics -->

        <h2 class="section-title">Dashboard Statistics</h2>

        <div class="stats-grid">

            <div class="stat-card">
                <h3>Total Teams</h3>
                <p class="stat-number">{{ $totalTeams }}</p>
            </div>

            <div class="stat-card">
                <h3>Total Players</h3>
                <p class="stat-number">{{ $totalPlayers }}</p>
            </div>

            <div class="stat-card">
                <h3>Total Matches</h3>
                <p class="stat-number">{{ $totalMatches }}</p>
            </div>

            <div class="stat-card">
                <h3>Completed Matches</h3>
                <p class="stat-number">{{ $completedMatches }}</p>
            </div>

        </div>

        <!-- Website navigation cards -->

        <h2 class="section-title">Explore Football Hub</h2>

        <div class="cards">

            <div class="card">
                <h3>Teams</h3>
                <p>View football teams and their information.</p>
                <a href="{{ route('teams') }}">View Teams</a>
            </div>

            <div class="card">
                <h3>Players</h3>
                <p>Explore football players and their details.</p>
                <a href="{{ route('players') }}">View Players</a>
            </div>

            <div class="card">
                <h3>Matches</h3>
                <p>Check upcoming and previous football matches.</p>
                <a href="{{ route('matches') }}">View Matches</a>
            </div>

            <div class="card">
                <h3>League Table</h3>
                <p>View team standings, points and goal difference.</p>
                <a href="{{ route('league-table') }}">View League Table</a>
            </div>

        </div>

        <!-- Live matches -->

        <section class="fixtures-section">

            <h2>Live Matches</h2>

            @forelse($liveFixtures->take(5) as $fixture)

                <div class="fixture-card">

                    <div class="fixture-league">
                        {{ data_get($fixture, 'league.name', 'Football Match') }}
                        <span class="match-badge live-badge">LIVE</span>
                    </div>

                    <div class="fixture-teams">

                        <div class="team-name">
                            {{ data_get($fixture, 'teams.home.name', 'Home Team') }}
                        </div>

                        <div class="fixture-score">
                            {{ data_get($fixture, 'goals.home', 0) }}
                            -
                            {{ data_get($fixture, 'goals.away', 0) }}
                        </div>

                        <div class="team-name">
                            {{ data_get($fixture, 'teams.away.name', 'Away Team') }}
                        </div>

                    </div>

                    <div class="fixture-status">
                        {{ data_get($fixture, 'fixture.status.long', 'In Progress') }}

                        @if(data_get($fixture, 'fixture.status.elapsed') !== null)
                            ({{ data_get($fixture, 'fixture.status.elapsed') }}')
                        @endif
                    </div>

                </div>

            @empty

                <div class="empty-message">
                    No live matches at the moment.
                </div>

            @endforelse


            <!-- Upcoming matches -->

            <h2>Upcoming Matches</h2>

            @forelse($upcomingFixtures->take(5) as $fixture)

                <div class="fixture-card">

                    <div class="fixture-league">
                        {{ data_get($fixture, 'league.name', 'Football Match') }}
                        <span class="match-badge upcoming-badge">UPCOMING</span>
                    </div>

                    <div class="fixture-teams">

                        <div class="team-name">
                            {{ data_get($fixture, 'teams.home.name', 'Home Team') }}
                        </div>

                        <div class="fixture-score">VS</div>

                        <div class="team-name">
                            {{ data_get($fixture, 'teams.away.name', 'Away Team') }}
                        </div>

                    </div>

                    <div class="fixture-status">
                        {{ \Illuminate\Support\Carbon::parse(data_get($fixture, 'fixture.date'))
                            ->setTimezone('Europe/London')
                            ->format('d M Y, H:i') }}
                    </div>

                </div>

            @empty

                <div class="empty-message">
                    No upcoming matches available today.
                </div>

            @endforelse


            <!-- Finished matches -->

            <h2>Finished Matches</h2>

            @forelse($finishedFixtures->take(5) as $fixture)

                <div class="fixture-card">

                    <div class="fixture-league">
                        {{ data_get($fixture, 'league.name', 'Football Match') }}
                        <span class="match-badge finished-badge">FT</span>
                    </div>

                    <div class="fixture-teams">

                        <div class="team-name">
                            {{ data_get($fixture, 'teams.home.name', 'Home Team') }}
                        </div>

                        <div class="fixture-score">
                            {{ data_get($fixture, 'goals.home') }}
                            -
                            {{ data_get($fixture, 'goals.away') }}
                        </div>

                        <div class="team-name">
                            {{ data_get($fixture, 'teams.away.name', 'Away Team') }}
                        </div>

                    </div>

                    <div class="fixture-status">
                        {{ \Illuminate\Support\Carbon::parse(data_get($fixture, 'fixture.date'))
                            ->setTimezone('Europe/London')
                            ->format('d M Y, H:i') }}
                    </div>

                </div>

            @empty

                <div class="empty-message">
                    No finished matches available today.
                </div>

            @endforelse

        </section>

    </div>

    <footer>
        Football Hub - Your Football Information Website
    </footer>

</body>
</html>
