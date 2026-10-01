<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Football Matches</title>

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

        .matches {
            display: flex;
            gap: 20px;
            margin-top: 25px;
        }

        .match {
            background: white;
            padding: 25px;
            flex: 1;
            border-radius: 10px;
            text-align: center;
        }

        .match h3 {
            color: #16a34a;
        }

        .match p {
            margin: 10px 0;
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
            <h2>Football Matches</h2>
            <p>Check upcoming and previous football matches.</p>
        </div>

        <div class="matches">

            <div class="match">
                <h3>Manchester United vs Liverpool</h3>
                <p><strong>Date:</strong> 5 October 2026</p>
                <p><strong>Time:</strong> 15:00</p>
                <p>Premier League</p>
            </div>

            <div class="match">
                <h3>Manchester City vs Arsenal</h3>
                <p><strong>Date:</strong> 6 October 2026</p>
                <p><strong>Time:</strong> 17:30</p>
                <p>Premier League</p>
            </div>

            <div class="match">
                <h3>Liverpool vs Chelsea</h3>
                <p><strong>Date:</strong> 10 October 2026</p>
                <p><strong>Time:</strong> 15:00</p>
                <p>Premier League</p>
            </div>

        </div>

    </div>

</body>
</html>