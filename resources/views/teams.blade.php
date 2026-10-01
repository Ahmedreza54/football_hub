<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Football Teams</title>

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

        header h1 {
            margin: 0;
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

        .teams {
            display: flex;
            gap: 20px;
            margin-top: 25px;
            flex-wrap: wrap;
        }

        .team-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            flex: 1;
            min-width: 200px;
        }

        .team-card h3 {
            color: #16a34a;
        }

        .team-card p {
            color: #333;
        }
    </style>
</head>

<body>

    <header>
        <h1>Football Hub</h1>
        <p>Your football information website</p>
    </header>

    <nav>
        <a href="/">Home</a>
        <a href="/teams">Teams</a>
        <a href="#">Players</a>
        <a href="#">Matches</a>
        <a href="#">News</a>
    </nav>

    <div class="container">

        <div class="welcome">
            <h2>Football Teams</h2>
            <p>Explore football teams and their information.</p>
        </div>

        <div class="teams">

            <div class="team-card">
                <h3>Manchester United</h3>
                <p>England</p>
            </div>

            <div class="team-card">
                <h3>Manchester City</h3>
                <p>England</p>
            </div>

            <div class="team-card">
                <h3>Liverpool</h3>
                <p>England</p>
            </div>

            <div class="team-card">
                <h3>Arsenal</h3>
                <p>England</p>
            </div>

        </div>

    </div>

</body>
</html>