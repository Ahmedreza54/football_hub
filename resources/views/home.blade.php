
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

        .cards {
            display: flex;
            gap: 20px;
            margin-top: 25px;
        }

        .card {
            background: white;
            padding: 25px;
            flex: 1;
            border-radius: 10px;
            text-align: center;
        }

        .card h3 {
            color: #16a34a;
        }

        .fixtures-section {
            margin-top: 35px;
        }

        .fixtures-section h2 {
            text-align: center;
            color: #111827;
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

        .empty-message {
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
        }

        @media (max-width: 700px) {
            .cards {
                flex-direction: column;
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
        <a href="#">News</a>
    </nav>

    <div class="container">

        <div class="welcome">
            <h2>Welcome to Football Hub</h2>
            <p>
                Find football teams, players, matches and the latest football information.
            </p>
        </div>

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

        </div>

        <!-- API Football Fixtures -->
        <section class="fixtures-section">

            <h2>Football Fixtures</h2>

            @forelse($fixtures as $fixture)

                <div class="fixture-card">

                    <div class="fixture-league">
                        {{ data_get($fixture, 'league.name', 'Football Match') }}
                    </div>

                    <div class="fixture-teams">

                        <div class="team-name">
                            {{ data_get($fixture, 'teams.home.name', 'Home Team') }}
                        </div>

                        <div class="fixture-score">

                            @if(data_get($fixture, 'goals.home') !== null &&
                                data_get($fixture, 'goals.away') !== null)

                                {{ data_get($fixture, 'goals.home') }}
                                -
                                {{ data_get($fixture, 'goals.away') }}

                            @else

                                VS

                            @endif

                        </div>

                        <div class="team-name">
                            {{ data_get($fixture, 'teams.away.name', 'Away Team') }}
                        </div>

                    </div>

                    <div class="fixture-status">

                        @php
                            $timestamp = data_get($fixture, 'fixture.timestamp');
                            $status = data_get($fixture, 'fixture.status.long', 'Scheduled');
                            $elapsed = data_get($fixture, 'fixture.status.elapsed');
                        @endphp

                        @if($timestamp)
                            {{ \Illuminate\Support\Carbon::createFromTimestamp((int) $timestamp)
                                ->setTimezone('Europe/London')
                                ->format('d M Y, H:i') }}
                        @else
                            {{ \Illuminate\Support\Carbon::parse(data_get($fixture, 'fixture.date'))
                                ->setTimezone('Europe/London')
                                ->format('d M Y, H:i') }}
                        @endif

                        |

                        {{ $status }}

                        @if($elapsed !== null)
                            ({{ $elapsed }}')
                        @endif

                    </div>

                </div>

            @empty

                <div class="empty-message">
                    <p>No football fixtures are currently available.</p>
                    <p>Please check again later.</p>
                </div>

            @endforelse

        </section>

    </div>

</body>
</html>
