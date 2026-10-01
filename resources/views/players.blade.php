<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Football Players</title>

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
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('teams') }}">Teams</a>
        <a href="{{ route('players') }}">Players</a>
        <a href="#">Matches</a>
        <a href="#">News</a>
    </nav>

    <div class="container">

        <div class="welcome">
            <h2>Football Players</h2>
            <p>Explore football players and their information.</p>
        </div>

        <div class="cards">

            <div class="card">
                <h3>Bruno Fernandes</h3>
                <p>Manchester United</p>
                <p>Portugal</p>
            </div>

            <div class="card">
                <h3>Erling Haaland</h3>
                <p>Manchester City</p>
                <p>Norway</p>
            </div>

            <div class="card">
                <h3>Mohamed Salah</h3>
                <p>Liverpool</p>
                <p>Egypt</p>
            </div>

        </div>

    </div>

</body>
</html>