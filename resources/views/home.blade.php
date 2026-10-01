<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Football Hub</title>

    <style>
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
    </style>
</head>

<body>

    <header>
        <h1>Football Hub</h1>
        <p>Your football information website</p>
    </header>

    <nav>
        <a href="{{ route('home') }}">Home</a>s
        <a href="{{ route('teams') }}">Teams</a>
        <a href="{{ route('players') }}">Players</a>
        <a href="#">Matches</a>
        <a href="#">News</a>
    </nav>

    <div class="container">

        <div class="welcome"
            <h2>Welcome to Football Hub</h2>
            <p>
                Find football teams, players, matches and the latest football information.
            </p>
        </div>

        <div class="cards">

            <div class="card">
                <h3>Teams</h3>
                <p>View football teams and their information.</p>
            </div>

            <div class="card">
                <h3>Players</h3>
                <p>Explore football players and their details.</p>
            </div>

            <div class="card">
                <h3>Matches</h3>
                <p>Check upcoming and previous football matches.</p>
            </div>

        </div>

    </div>

</body>
</html>