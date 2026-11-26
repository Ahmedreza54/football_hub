
@extends('layouts.app')

@section('title', $player->name . ' - Player Profile')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white py-3">
                    <h3 class="mb-0">Player Profile</h3>
                </div>

                <div class="card-body p-4">

                    <div class="text-center mb-4">
                        <div class="bg-primary text-white rounded-circle d-inline-flex
                                    align-items-center justify-content-center"
                             style="width: 90px; height: 90px; font-size: 36px;">
                            {{ strtoupper(substr($player->name, 0, 1)) }}
                        </div>

                        <h2 class="mt-3">{{ $player->name }}</h2>
                        <p class="text-muted mb-0">Football Player</p>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Player Name</div>
                        <div class="col-sm-8">
                            {{ $player->name }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Position</div>
                        <div class="col-sm-8">
                            {{ $player->position }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Team</div>
                        <div class="col-sm-8">
                            {{ $player->team->name ?? 'No team assigned' }}
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('players') }}"
                           class="btn btn-primary">
                            Back to Players
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
