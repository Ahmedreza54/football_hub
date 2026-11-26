
@extends('layouts.app')

@section('title', 'Teams - Football Hub')

@section('content')

<!-- Page heading -->
<div class="text-center mb-5">
    <h1 class="fw-bold">Football Teams</h1>
    <p class="text-secondary">
        Explore football teams and their information.
    </p>
</div>

<!-- Success message -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}

        <button type="button" class="btn-close"
                data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Validation errors -->
@if($errors->any())
    <div class="alert alert-danger">
        <strong>Please correct the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Add new team -->
<div class="card shadow-sm border-0 mb-5">
    <div class="card-header bg-primary text-white">
        <h2 class="h5 mb-0">Add New Team</h2>
    </div>

    <div class="card-body">
        <form action="{{ route('teams.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-12 col-md-5">
                    <label for="name" class="form-label">Team Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Enter team name"
                        value="{{ old('name') }}"
                        required
                    >

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-5">
                    <label for="country" class="form-label">Country</label>
                    <input
                        type="text"
                        id="country"
                        name="country"
                        class="form-control @error('country') is-invalid @enderror"
                        placeholder="Enter country"
                        value="{{ old('country') }}"
                        required
                    >

                    @error('country')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">
                        Add Team
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Favourite teams -->
<div class="card shadow-sm border-0 mb-5">
    <div class="card-body">
        <h2 class="h5 mb-3">⭐ My Favourite Teams</h2>

        <div id="favouriteTeams" aria-live="polite">
            <p class="text-secondary mb-0">
                No favourite teams saved yet.
            </p>
        </div>
    </div>
</div>

<!-- Display teams -->
<h2 class="h4 mb-4">All Teams</h2>

<div class="row g-4">
    @forelse($teams as $team)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h3 class="h5 card-title text-primary">
                        {{ $team->name }}
                    </h3>

                    <p class="card-text text-secondary">
                        <strong>Country:</strong> {{ $team->country }}
                    </p>

                    <div class="d-grid gap-2">
                        <button
                            type="button"
                            class="btn btn-outline-primary favourite-button"
                            data-team-id="{{ $team->id }}"
                            data-team-name="{{ $team->name }}"
                        >
                            ☆ Add to Favourites
                        </button>

                        <form
                            action="{{ route('teams.destroy', $team) }}"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this team?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger w-100">
                                Delete Team
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <h3 class="h5">No teams found</h3>
                <p class="mb-0">
                    Add your first football team using the form above.
                </p>
            </div>
        </div>
    @endforelse
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const storageKey = 'footballHubFavouriteTeams';
    const favouriteContainer = document.getElementById('favouriteTeams');
    const favouriteButtons = document.querySelectorAll('.favourite-button');

    function getFavourites() {
        try {
            return JSON.parse(localStorage.getItem(storageKey)) || [];
        } catch (error) {
            console.error('Unable to read favourite teams:', error);
            return [];
        }
    }

    function saveFavourites(favourites) {
        try {
            localStorage.setItem(storageKey, JSON.stringify(favourites));
            return true;
        } catch (error) {
            console.error('Unable to save favourite teams:', error);
            alert('Your favourites could not be saved in this browser.');
            return false;
        }
    }

    function updateFavouriteButtons() {
        const favourites = getFavourites();

        favouriteButtons.forEach(function (button) {
            const isFavourite = favourites.some(function (team) {
                return String(team.id) === button.dataset.teamId;
            });

            button.textContent = isFavourite
                ? '★ Remove from Favourites'
                : '☆ Add to Favourites';

            button.classList.toggle('btn-primary', isFavourite);
            button.classList.toggle('btn-outline-primary', !isFavourite);
        });
    }

    function displayFavourites() {
        const favourites = getFavourites();

        favouriteContainer.replaceChildren();

        if (favourites.length === 0) {
            const message = document.createElement('p');
            message.className = 'text-secondary mb-0';
            message.textContent = 'No favourite teams saved yet.';
            favouriteContainer.appendChild(message);
            return;
        }

        const list = document.createElement('div');
        list.className = 'd-flex flex-wrap gap-2';

        favourites.forEach(function (team) {
            const item = document.createElement('span');
            item.className = 'badge bg-primary p-2';
            item.textContent = team.name;
            list.appendChild(item);
        });

        favouriteContainer.appendChild(list);
    }

    favouriteButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const teamId = button.dataset.teamId;
            const teamName = button.dataset.teamName;

            let favourites = getFavourites();

            const alreadyFavourite = favourites.some(function (team) {
                return String(team.id) === teamId;
            });

            if (alreadyFavourite) {
                favourites = favourites.filter(function (team) {
                    return String(team.id) !== teamId;
                });
            } else {
                favourites.push({
                    id: teamId,
                    name: teamName
                });
            }

            if (saveFavourites(favourites)) {
                updateFavouriteButtons();
                displayFavourites();
            }
        });
    });

    updateFavouriteButtons();
    displayFavourites();
});
</script>
@endsection
