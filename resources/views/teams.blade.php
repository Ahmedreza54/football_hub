
@extends('layouts.app')

@section('title', 'Teams - Football Hub')

@section('content')

<div class="text-center mb-5">
    <h1 class="fw-bold">Football Teams</h1>
    <p class="text-secondary">Explore football teams and their information.</p>
</div>

<div id="teamMessage" aria-live="polite"></div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

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
                    <input type="text" id="name" name="name"
                           class="form-control" placeholder="Enter team name"
                           value="{{ old('name') }}" required>
                </div>

                <div class="col-12 col-md-5">
                    <label for="country" class="form-label">Country</label>
                    <input type="text" id="country" name="country"
                           class="form-control" placeholder="Enter country"
                           value="{{ old('country') }}" required>
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
            <p class="text-secondary mb-0">No favourite teams saved yet.</p>
        </div>
    </div>
</div>

<!-- AJAX Search -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h2 class="h5 mb-3">Search Teams</h2>

        <input type="search" id="teamSearch"
               class="form-control"
               placeholder="Search by team name or country..."
               autocomplete="off">

        <small class="text-secondary">
            Results update automatically as you type.
        </small>
    </div>
</div>

<h2 class="h4 mb-4">All Teams</h2>

<div class="row g-4" id="teamsContainer">
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
                        <button type="button"
                                class="btn btn-outline-primary favourite-button"
                                data-team-id="{{ $team->id }}"
                                data-team-name="{{ $team->name }}">
                            ☆ Add to Favourites
                        </button>

                        <form action="{{ route('teams.destroy', $team) }}"
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this team?')">
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
                No teams found. Add your first football team above.
            </div>
        </div>
    @endforelse
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const storageKey = 'footballHubFavouriteTeams';
    const searchInput = document.getElementById('teamSearch');
    const teamsContainer = document.getElementById('teamsContainer');
    const favouriteContainer = document.getElementById('favouriteTeams');
    const messageContainer = document.getElementById('teamMessage');

    let searchTimer;

    function getFavourites() {
        try {
            return JSON.parse(localStorage.getItem(storageKey)) || [];
        } catch (error) {
            console.error('Unable to read favourites:', error);
            return [];
        }
    }

    function saveFavourites(favourites) {
        try {
            localStorage.setItem(storageKey, JSON.stringify(favourites));
            return true;
        } catch (error) {
            console.error('Unable to save favourites:', error);
            return false;
        }
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

    function updateFavouriteButtons() {
        const favourites = getFavourites();

        document.querySelectorAll('.favourite-button').forEach(function (button) {
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

    function createTeamCard(team) {
        const column = document.createElement('div');
        column.className = 'col-12 col-md-6 col-lg-4';

        const card = document.createElement('div');
        card.className = 'card shadow-sm border-0 h-100';

        const body = document.createElement('div');
        body.className = 'card-body text-center';

        const heading = document.createElement('h3');
        heading.className = 'h5 card-title text-primary';
        heading.textContent = team.name;

        const country = document.createElement('p');
        country.className = 'card-text text-secondary';
        country.textContent = 'Country: ' + team.country;

        const actions = document.createElement('div');
        actions.className = 'd-grid gap-2';

        const favouriteButton = document.createElement('button');
        favouriteButton.type = 'button';
        favouriteButton.className = 'btn btn-outline-primary favourite-button';
        favouriteButton.dataset.teamId = team.id;
        favouriteButton.dataset.teamName = team.name;
        favouriteButton.textContent = '☆ Add to Favourites';

        const deleteForm = document.createElement('form');
        deleteForm.action = '/teams/' + encodeURIComponent(team.id);
        deleteForm.method = 'POST';
        deleteForm.innerHTML = `
            <input type="hidden" name="_token"
                   value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger w-100">
                Delete Team
            </button>
        `;

        deleteForm.addEventListener('submit', function (event) {
            if (!confirm('Are you sure you want to delete this team?')) {
                event.preventDefault();
            }
        });

        actions.appendChild(favouriteButton);
        actions.appendChild(deleteForm);

        body.appendChild(heading);
        body.appendChild(country);
        body.appendChild(actions);

        card.appendChild(body);
        column.appendChild(card);

        return column;
    }

    function displayTeams(teams) {
        teamsContainer.replaceChildren();

        if (teams.length === 0) {
            const empty = document.createElement('div');
            empty.className = 'col-12';

            const alert = document.createElement('div');
            alert.className = 'alert alert-info text-center';
            alert.textContent = 'No teams found. Try another search.';

            empty.appendChild(alert);
            teamsContainer.appendChild(empty);
            return;
        }

        teams.forEach(function (team) {
            teamsContainer.appendChild(createTeamCard(team));
        });

        updateFavouriteButtons();
    }

    async function searchTeams() {
        const search = searchInput.value.trim();

        try {
            teamsContainer.innerHTML = `
                <div class="col-12 text-center">
                    <p class="text-secondary">Searching teams...</p>
                </div>
            `;

            const response = await fetch(
                '{{ route("teams") }}?search=' + encodeURIComponent(search),
                {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }
            );

            if (!response.ok) {
                throw new Error('Unable to search teams.');
            }

            const data = await response.json();
            displayTeams(data.teams || []);

        } catch (error) {
            console.error(error);
            teamsContainer.innerHTML = `
                <div class="col-12">
                    <div class="alert alert-danger">
                        Search failed. Please try again.
                    </div>
                </div>
            `;
        }
    }

    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(searchTeams, 300);
    });

    teamsContainer.addEventListener('click', function (event) {
        const button = event.target.closest('.favourite-button');

        if (!button) return;

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

    displayFavourites();
    updateFavouriteButtons();
});
</script>
@endsection
