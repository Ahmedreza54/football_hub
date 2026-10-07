<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Football Teams</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">

            <a class="navbar-brand fw-bold" href="/">
                Football Hub
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="/teams">Teams</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/players">Players</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/matches">Matches</a>
                    </li>

                </ul>

            </div>
        </div>
    </nav>


    <!-- Main content -->
    <div class="container py-5">

        <!-- Page heading -->
        <div class="text-center mb-5">

            <h1 class="fw-bold">
                Football Teams
            </h1>

            <p class="text-muted">
                Explore football teams and their information.
            </p>

        </div>


        <!-- Success message -->
        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show" role="alert">

                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>

            </div>

        @endif


        <!-- Add Team -->
        <div class="card shadow-sm mb-5">

            <div class="card-header bg-primary text-white">

                <h4 class="mb-0">
                    Add New Team
                </h4>

            </div>

            <div class="card-body">

                <form action="{{ route('teams.store') }}" method="POST">

                    @csrf

                    <div class="row g-3">

                        <div class="col-md-5">

                            <label class="form-label">
                                Team Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                placeholder="Enter team name"
                                required
                            >

                        </div>


                        <div class="col-md-5">

                            <label class="form-label">
                                Country
                            </label>

                            <input
                                type="text"
                                name="country"
                                class="form-control"
                                placeholder="Enter country"
                                required
                            >

                        </div>


                        <div class="col-md-2 d-flex align-items-end">

                            <button
                                type="submit"
                                class="btn btn-success w-100"
                            >
                                Add Team
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        <!-- Teams -->
        <div class="row g-4">

            @forelse($teams as $team)

                <div class="col-md-6 col-lg-4">

                    <div class="card shadow-sm h-100">

                        <div class="card-body text-center">

                            <h4 class="card-title text-primary">
                                {{ $team->name }}
                            </h4>

                            <p class="card-text">

                                <strong>Country:</strong>
                                {{ $team->country }}

                            </p>


                            <form
                                action="{{ route('teams.destroy', $team) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this team?')"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger"
                                >
                                    Delete
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12">

                    <div class="alert alert-info text-center">

                        <h5>
                            No teams found
                        </h5>

                        <p class="mb-0">
                            Add your first football team above.
                        </p>

                    </div>

                </div>

            @endforelse

        </div>

    </div>


    <!-- Bootstrap JavaScript -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>

</body>
</html>