@extends('layouts.app')

@section('title', 'Matches - Football Hub')

@section('content')

<!-- Page heading -->
<div class="text-center mb-5">
    <h1 class="display-5 fw-bold">Football Matches</h1>
    <p class="lead text-secondary">
        Manage football matches, scores and results.
    </p>
</div>

<!-- Match Reminders -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-warning text-dark d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h2 class="h5 mb-0">Match Reminders</h2>

        <button type="button" class="btn btn-dark btn-sm" id="enableNotifications">
            Enable Browser Notifications
        </button>
    </div>

    <div class="card-body">
        <p class="text-secondary small mb-3">
            Reminders appear here one hour before scheduled matches.
            Browser notifications require permission and this page to remain open.
        </p>

        <div id="reminderList" aria-live="polite">
            <p class="text-secondary mb-0">Loading reminders...</p>
        </div>

        <p id="notificationStatus"
           class="small text-secondary mt-2 mb-0"
           role="status"></p>
    </div>
</div>

<!-- AJAX response message -->
<div id="matchMessage" class="alert d-none" role="alert" aria-live="polite"></div>

<!-- Success message for normal form submissions -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}

        <button type="button" class="btn-close"
                data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Validation errors for normal form submissions -->
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

<!-- Add New Match -->
<div class="card shadow-sm border-0 mb-5">
    <div class="card-header bg-primary text-white">
        <h2 class="h5 mb-0">Add New Match</h2>
    </div>

    <div class="card-body">

        <form id="addMatchForm"
              action="{{ route('matches.store') }}"
              method="POST">

            @csrf

            <div class="row g-3">

                <!-- Home Team -->
                <div class="col-12 col-md-6">
                    <label for="home_team_id" class="form-label">Home Team</label>

                    <select name="home_team_id"
                            id="home_team_id"
                            class="form-select @error('home_team_id') is-invalid @enderror"
                            required>
                        <option value="">Select Home Team</option>

                        @foreach($teams as $team)
                            <option value="{{ $team->id }}"
                                {{ old('home_team_id') == $team->id ? 'selected' : '' }}>
                                {{ $team->name }}
                            </option>
                        @endforeach
                    </select>

                    <div class="invalid-feedback" data-error="home_team_id">
                        @error('home_team_id'){{ $message }}@enderror
                    </div>
                </div>

                <!-- Away Team -->
                <div class="col-12 col-md-6">
                    <label for="away_team_id" class="form-label">Away Team</label>

                    <select name="away_team_id"
                            id="away_team_id"
                            class="form-select @error('away_team_id') is-invalid @enderror"
                            required>
                        <option value="">Select Away Team</option>

                        @foreach($teams as $team)
                            <option value="{{ $team->id }}"
                                {{ old('away_team_id') == $team->id ? 'selected' : '' }}>
                                {{ $team->name }}
                            </option>
                        @endforeach
                    </select>

                    <div class="invalid-feedback" data-error="away_team_id">
                        @error('away_team_id'){{ $message }}@enderror
                    </div>
                </div>

                <!-- Match Date -->
                <div class="col-12 col-md-4">
                    <label for="match_date" class="form-label">Match Date & Time</label>

                    <input type="datetime-local"
                           name="match_date"
                           id="match_date"
                           class="form-control @error('match_date') is-invalid @enderror"
                           value="{{ old('match_date') }}"
                           required>

                    <div class="invalid-feedback" data-error="match_date">
                        @error('match_date'){{ $message }}@enderror
                    </div>
                </div>

                <!-- Venue -->
                <div class="col-12 col-md-4">
                    <label for="venue" class="form-label">Venue</label>

                    <input type="text"
                           name="venue"
                           id="venue"
                           class="form-control @error('venue') is-invalid @enderror"
                           value="{{ old('venue') }}"
                           placeholder="Enter venue"
                           required>

                    <div class="invalid-feedback" data-error="venue">
                        @error('venue'){{ $message }}@enderror
                    </div>
                </div>

                <!-- Status -->
                <div class="col-12 col-md-4">
                    <label for="status" class="form-label">Status</label>

                    <select name="status"
                            id="status"
                            class="form-select @error('status') is-invalid @enderror"
                            required>
                        @foreach(['Scheduled', 'Completed', 'Postponed', 'Cancelled'] as $status)
                            <option value="{{ $status }}"
                                {{ old('status', 'Scheduled') == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>

                    <div class="invalid-feedback" data-error="status">
                        @error('status'){{ $message }}@enderror
                    </div>
                </div>

                <!-- Home Score -->
                <div class="col-12 col-md-6">
                    <label for="home_score" class="form-label">Home Team Score</label>

                    <input type="number"
                           name="home_score"
                           id="home_score"
                           class="form-control @error('home_score') is-invalid @enderror"
                           min="0"
                           value="{{ old('home_score') }}"
                           placeholder="Enter home team score">

                    <div class="invalid-feedback" data-error="home_score">
                        @error('home_score'){{ $message }}@enderror
                    </div>
                </div>

                <!-- Away Score -->
                <div class="col-12 col-md-6">
                    <label for="away_score" class="form-label">Away Team Score</label>

                    <input type="number"
                           name="away_score"
                           id="away_score"
                           class="form-control @error('away_score') is-invalid @enderror"
                           min="0"
                           value="{{ old('away_score') }}"
                           placeholder="Enter away team score">

                    <div class="invalid-feedback" data-error="away_score">
                        @error('away_score'){{ $message }}@enderror
                    </div>
                </div>

                <!-- Submit -->
                <div class="col-12">
                    <button type="submit" id="addMatchButton" class="btn btn-success">
                        Add Match
                    </button>

                    <span id="formLoading" class="text-secondary small ms-2 d-none">
                        Adding match...
                    </span>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- Matches List -->
<h2 class="h4 mb-4">All Matches</h2>

<div class="row g-4" id="matchesContainer">

    @forelse($matches as $match)

        <div class="col-12 col-md-6 col-lg-4"
             data-match-card
             data-match-id="{{ $match->id }}">

            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">

                    <!-- Teams -->
                    <h3 class="h5 text-primary fw-bold">
                        {{ $match->homeTeam->name }}
                        <span class="text-secondary">vs</span>
                        {{ $match->awayTeam->name }}
                    </h3>

                    <!-- Match Score -->
                    @if($match->home_score !== null && $match->away_score !== null)
                        <h2 class="fw-bold text-success my-3">
                            {{ $match->home_score }} - {{ $match->away_score }}
                        </h2>
                    @else
                        <p class="text-secondary my-3">
                            Score not available yet
                        </p>
                    @endif

                    <hr>

                    <!-- Date -->
                    <p class="mb-2">
                        <strong>Date:</strong>
                        {{ \Carbon\Carbon::parse($match->match_date)->format('d F Y') }}
                    </p>

                    <!-- Time -->
                    <p class="mb-2">
                        <strong>Time:</strong>
                        {{ \Carbon\Carbon::parse($match->match_date)->format('H:i') }}
                    </p>

                    <!-- Venue -->
                    <p class="mb-2">
                        <strong>Venue:</strong>
                        {{ $match->venue }}
                    </p>

                    <!-- Status -->
                    <p class="mb-3">
                        <strong>Status:</strong>

                        <span class="badge
                            @if($match->status === 'Completed')
                                bg-success
                            @elseif($match->status === 'Cancelled')
                                bg-danger
                            @elseif($match->status === 'Postponed')
                                bg-warning text-dark
                            @else
                                bg-primary
                            @endif
                        ">
                            {{ $match->status }}
                        </span>
                    </p>

                    <!-- Edit and Delete -->
                    <div class="d-flex justify-content-center gap-2 flex-wrap">

                        <a href="{{ route('matches.edit', $match) }}"
                           class="btn btn-primary btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('matches.destroy', $match) }}"
                              method="POST"
                              class="delete-match-form">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    @empty

        <div class="col-12" id="noMatchesMessage">
            <div class="alert alert-info text-center">
                No matches have been added yet.
            </div>
        </div>

    @endforelse

</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // ADD MATCH USING FETCH API
    // ==========================================

    const addMatchForm = document.getElementById('addMatchForm');
    const addMatchButton = document.getElementById('addMatchButton');
    const formLoading = document.getElementById('formLoading');
    const matchMessage = document.getElementById('matchMessage');
    const matchesContainer = document.getElementById('matchesContainer');

    const editUrlTemplate = @json(route('matches.edit', ['footballMatch' => '__MATCH_ID__']));
    const deleteUrlTemplate = @json(route('matches.destroy', ['footballMatch' => '__MATCH_ID__']));

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, function (character) {
            return ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            })[character];
        });
    }

    function showMatchMessage(message, type) {
        matchMessage.textContent = message;
        matchMessage.className = 'alert alert-' + type;
        matchMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function clearValidationErrors() {
        addMatchForm.querySelectorAll('.is-invalid').forEach(function (field) {
            field.classList.remove('is-invalid');
        });

        addMatchForm.querySelectorAll('[data-error]').forEach(function (errorElement) {
            errorElement.textContent = '';
        });
    }

    function showValidationErrors(errors) {
        clearValidationErrors();

        Object.keys(errors).forEach(function (fieldName) {
            const field = addMatchForm.querySelector('[name="' + fieldName + '"]');
            const errorElement = addMatchForm.querySelector('[data-error="' + fieldName + '"]');

            if (field) {
                field.classList.add('is-invalid');
            }

            if (errorElement) {
                errorElement.textContent = errors[fieldName][0];
            }
        });
    }

    function formatMatchDate(value) {
        const date = new Date(String(value).replace(' ', 'T'));

        if (Number.isNaN(date.getTime())) {
            return escapeHtml(value);
        }

        return date.toLocaleDateString([], {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
    }

    function formatMatchTime(value) {
        const date = new Date(String(value).replace(' ', 'T'));

        if (Number.isNaN(date.getTime())) {
            return '';
        }

        return date.toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function getStatusClass(status) {
        switch (status) {
            case 'Completed':
                return 'bg-success';
            case 'Cancelled':
                return 'bg-danger';
            case 'Postponed':
                return 'bg-warning text-dark';
            default:
                return 'bg-primary';
        }
    }

    function createMatchCard(match) {
        const homeTeam = match.home_team?.name || match.homeTeam?.name || 'Home Team';
        const awayTeam = match.away_team?.name || match.awayTeam?.name || 'Away Team';

        const hasScore = match.home_score !== null &&
                         match.home_score !== undefined &&
                         match.away_score !== null &&
                         match.away_score !== undefined;

        const editUrl = editUrlTemplate.replace('__MATCH_ID__', encodeURIComponent(match.id));
        const deleteUrl = deleteUrlTemplate.replace('__MATCH_ID__', encodeURIComponent(match.id));

        return `
            <div class="col-12 col-md-6 col-lg-4"
                 data-match-card
                 data-match-id="${escapeHtml(match.id)}">

                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">

                        <h3 class="h5 text-primary fw-bold">
                            ${escapeHtml(homeTeam)}
                            <span class="text-secondary">vs</span>
                            ${escapeHtml(awayTeam)}
                        </h3>

                        ${
                            hasScore
                                ? `<h2 class="fw-bold text-success my-3">
                                       ${escapeHtml(match.home_score)} - ${escapeHtml(match.away_score)}
                                   </h2>`
                                : `<p class="text-secondary my-3">Score not available yet</p>`
                        }

                        <hr>

                        <p class="mb-2">
                            <strong>Date:</strong> ${formatMatchDate(match.match_date)}
                        </p>

                        <p class="mb-2">
                            <strong>Time:</strong> ${formatMatchTime(match.match_date)}
                        </p>

                        <p class="mb-2">
                            <strong>Venue:</strong> ${escapeHtml(match.venue)}
                        </p>

                        <p class="mb-3">
                            <strong>Status:</strong>
                            <span class="badge ${getStatusClass(match.status)}">
                                ${escapeHtml(match.status)}
                            </span>
                        </p>

                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <a href="${editUrl}" class="btn btn-primary btn-sm">
                                Edit
                            </a>

                            <form action="${deleteUrl}"
                                  method="POST"
                                  class="delete-match-form">

                                <input type="hidden" name="_token"
                                       value="${escapeHtml(document.querySelector('input[name=_token]').value)}">

                                <input type="hidden" name="_method" value="DELETE">

                                <button type="submit" class="btn btn-danger btn-sm">
                                    Delete
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        `;
    }

    // Add Match form submission
    addMatchForm.addEventListener('submit', async function (event) {
        event.preventDefault();

        clearValidationErrors();

        matchMessage.className = 'alert d-none';

        addMatchButton.disabled = true;
        formLoading.classList.remove('d-none');

        try {
            const response = await fetch(addMatchForm.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new FormData(addMatchForm)
            });

            const data = await response.json();

            if (response.status === 422) {
                showValidationErrors(data.errors || {});
                showMatchMessage('Please correct the errors in the form.', 'danger');
                return;
            }

            if (!response.ok) {
                throw new Error(data.message || 'Unable to add the match.');
            }

            const emptyMessage = document.getElementById('noMatchesMessage');

            if (emptyMessage) {
                emptyMessage.remove();
            }

            matchesContainer.insertAdjacentHTML(
                'afterbegin',
                createMatchCard(data.match)
            );

            addMatchForm.reset();

            showMatchMessage(data.message || 'Match added successfully!', 'success');

        } catch (error) {
            console.error('Add match error:', error);

            showMatchMessage(
                error.message || 'Something went wrong. Please try again.',
                'danger'
            );

        } finally {
            addMatchButton.disabled = false;
            formLoading.classList.add('d-none');
        }
    });


    // ==========================================
    // DELETE MATCH USING FETCH API
    // ==========================================

    matchesContainer.addEventListener('submit', async function (event) {

        const form = event.target.closest('.delete-match-form');

        if (!form) {
            return;
        }

        event.preventDefault();

        if (!confirm('Are you sure you want to delete this match?')) {
            return;
        }

        const button = form.querySelector('button[type="submit"]');
        const originalText = button.textContent;
        const matchCard = form.closest('[data-match-card]');

        button.disabled = true;
        button.textContent = 'Deleting...';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new FormData(form)
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Unable to delete match.');
            }

            // Remove the deleted match from the page.
            matchCard.remove();

            // Display a message if no matches remain.
            if (!matchesContainer.querySelector('[data-match-card]')) {
                matchesContainer.innerHTML = `
                    <div class="col-12" id="noMatchesMessage">
                        <div class="alert alert-info text-center">
                            No matches have been added yet.
                        </div>
                    </div>
                `;
            }

            showMatchMessage(
                data.message || 'Match deleted successfully!',
                'success'
            );

        } catch (error) {
            console.error('Delete match error:', error);

            showMatchMessage(
                error.message || 'Something went wrong. Please try again.',
                'danger'
            );

            button.disabled = false;
            button.textContent = originalText;
        }
    });


    // ==========================================
    // MATCH REMINDERS USING FETCH API
    // ==========================================

    const remindersUrl = @json(route('match-reminders.index'));
    const reminderList = document.getElementById('reminderList');
    const enableButton = document.getElementById('enableNotifications');
    const notificationStatus = document.getElementById('notificationStatus');

    let knownReminderIds = null;

    function formatReminderDate(value) {
        const date = new Date(String(value).replace(' ', 'T'));

        if (Number.isNaN(date.getTime())) {
            return escapeHtml(value);
        }

        return date.toLocaleString([], {
            dateStyle: 'medium',
            timeStyle: 'short'
        });
    }

    function showBrowserNotification(reminder) {

        if (!('Notification' in window) ||
            Notification.permission !== 'granted') {
            return;
        }

        const title = reminder.home_team + ' vs ' + reminder.away_team;

        const notification = new Notification('Football Hub match reminder', {
            body: title + '\nKick-off: ' + formatReminderDate(reminder.match_date)
                + (reminder.venue ? '\nVenue: ' + reminder.venue : ''),
            tag: 'football-hub-reminder-' + reminder.id
        });

        notification.onclick = function () {
            window.focus();
            notification.close();
        };
    }

    function renderReminders(reminders) {

        if (!reminders.length) {
            reminderList.innerHTML =
                '<p class="text-secondary mb-0">No match reminders yet. Reminders will appear here one hour before kick-off.</p>';
            return;
        }

        reminderList.innerHTML = reminders.map(function (reminder) {
            return `
                <div class="alert alert-warning mb-2">
                    <strong>${escapeHtml(reminder.home_team)} vs ${escapeHtml(reminder.away_team)}</strong>

                    <div class="small mt-1">
                        Kick-off: ${formatReminderDate(reminder.match_date)}
                        ${reminder.venue ? ' · Venue: ' + escapeHtml(reminder.venue) : ''}
                    </div>

                    <div class="small text-secondary">
                        Reminder processed: ${formatReminderDate(reminder.sent_at)}
                    </div>
                </div>
            `;
        }).join('');
    }

    async function loadReminders() {

        try {
            const response = await fetch(remindersUrl, {
                headers: {
                    'Accept': 'application/json'
                },
                cache: 'no-store'
            });

            if (!response.ok) {
                throw new Error('Could not load reminders.');
            }

            const reminders = await response.json();

            renderReminders(reminders);

            const currentIds = new Set(
                reminders.map(reminder => Number(reminder.id))
            );

            if (knownReminderIds !== null) {

                reminders.forEach(function (reminder) {

                    if (!knownReminderIds.has(Number(reminder.id))) {
                        showBrowserNotification(reminder);
                    }

                });
            }

            knownReminderIds = currentIds;

        } catch (error) {
            reminderList.innerHTML =
                '<p class="text-danger mb-0">Unable to load reminders. Please refresh the page.</p>';

            console.error(error);
        }
    }

    enableButton.addEventListener('click', async function () {

        if (!('Notification' in window)) {
            notificationStatus.textContent =
                'This browser does not support desktop notifications.';
            return;
        }

        const permission = await Notification.requestPermission();

        notificationStatus.textContent =
            permission === 'granted'
                ? 'Browser notifications are enabled. Keep this page open to receive them.'
                : 'Browser notifications are not enabled. You can still see reminders on this page.';
    });

    if (!('Notification' in window)) {

        enableButton.disabled = true;

        notificationStatus.textContent =
            'This browser does not support desktop notifications.';

    } else if (Notification.permission === 'granted') {

        notificationStatus.textContent =
            'Browser notifications are already enabled.';

    } else if (Notification.permission === 'denied') {

        notificationStatus.textContent =
            'Browser notifications are blocked in browser settings.';
    }

    loadReminders();

    window.setInterval(loadReminders, 30000);

});
</script>
@endsection