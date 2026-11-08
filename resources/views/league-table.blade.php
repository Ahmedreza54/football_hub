
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Football League Table - Football Hub</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f4f4f4;
            color: #111827;
        }

        header {
            background: #111827;
            color: white;
            padding: 25px;
            text-align: center;
        }

        nav {
            background: #1f2937;
            padding: 14px;
            text-align: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 12px;
        }

        nav a:hover {
            color: #22c55e;
        }

        .container {
            width: 95%;
            max-width: 1100px;
            margin: 35px auto;
        }

        .table-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        .description {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        th, td {
            padding: 13px 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #1f2937;
            color: white;
        }

        td.team {
            text-align: left;
            font-weight: bold;
        }

        tr:hover {
            background: #f0fdf4;
        }

        .points {
            color: #16a34a;
            font-weight: bold;
        }

        .empty-message {
            text-align: center;
            padding: 25px;
            color: #666;
        }

        footer {
            text-align: center;
            padding: 20px;
            color: #666;
        }

        @media (max-width: 600px) {
            .table-card {
                padding: 12px;
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
</nav>

<div class="container">

    <div class="table-card">

        <h2>Football League Table</h2>

        <p class="description">
            Team standings calculated from completed matches.
        </p>

        @if(count($table) > 0)

            <div class="table-wrapper">

                <table>
                    <thead>
                        <tr>
                            <th>Pos</th>
                            <th>Team</th>
                            <th>P</th>
                            <th>W</th>
                            <th>D</th>
                            <th>L</th>
                            <th>GF</th>
                            <th>GA</th>
                            <th>GD</th>
                            <th>PTS</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($table as $index => $team)

                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td class="team">
                                    {{ $team['team'] }}
                                </td>

                                <td>{{ $team['played'] }}</td>
                                <td>{{ $team['won'] }}</td>
                                <td>{{ $team['drawn'] }}</td>
                                <td>{{ $team['lost'] }}</td>
                                <td>{{ $team['gf'] }}</td>
                                <td>{{ $team['ga'] }}</td>
                                <td>{{ $team['gd'] }}</td>

                                <td class="points">
                                    {{ $team['points'] }}
                                </td>
                            </tr>

                        @endforeach

                    </tbody>
                </table>

            </div>

        @else

            <div class="empty-message">
                <h3>No League Results Yet</h3>
                <p>
                    Complete some matches and add their scores
                    to see the league standings.
                </p>
            </div>

        @endif

    </div>

</div>

<footer>
    <p>Football Hub - League Table</p>
</footer>

</body>
</html>
