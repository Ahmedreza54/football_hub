
@extends('layouts.app')

@section('title', 'League Table - Football Hub')

@section('content')

<!-- Page heading -->
<div class="text-center mb-4">
    <h1 class="display-5 fw-bold">Football League Table</h1>

    <p class="lead text-secondary">
        Team standings calculated from completed matches.
    </p>
</div>

<!-- League table card -->
<div class="card shadow-sm border-0">

    <div class="card-header bg-primary text-white">
        <h2 class="h5 mb-0">League Standings</h2>
    </div>

    <div class="card-body">

        @if(count($table) > 0)

            <!-- Responsive table -->
            <div class="table-responsive">

                <table class="table table-striped table-hover table-bordered align-middle text-center mb-0">

                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Pos</th>
                            <th scope="col" class="text-start">Team</th>
                            <th scope="col">P</th>
                            <th scope="col">W</th>
                            <th scope="col">D</th>
                            <th scope="col">L</th>
                            <th scope="col">GF</th>
                            <th scope="col">GA</th>
                            <th scope="col">GD</th>
                            <th scope="col">PTS</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($table as $index => $team)

                            <tr>
                                <td class="fw-semibold">
                                    {{ $index + 1 }}
                                </td>

                                <td class="text-start fw-bold">
                                    {{ $team['team'] }}
                                </td>

                                <td>{{ $team['played'] }}</td>
                                <td>{{ $team['won'] }}</td>
                                <td>{{ $team['drawn'] }}</td>
                                <td>{{ $team['lost'] }}</td>
                                <td>{{ $team['gf'] }}</td>
                                <td>{{ $team['ga'] }}</td>

                                <td>
                                    @if($team['gd'] > 0)
                                        <span class="text-success fw-semibold">
                                            +{{ $team['gd'] }}
                                        </span>
                                    @elseif($team['gd'] < 0)
                                        <span class="text-danger fw-semibold">
                                            {{ $team['gd'] }}
                                        </span>
                                    @else
                                        {{ $team['gd'] }}
                                    @endif
                                </td>

                                <td class="text-success fw-bold">
                                    {{ $team['points'] }}
                                </td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <div class="mt-3 text-secondary small">
                P = Played | W = Won | D = Drawn | L = Lost |
                GF = Goals For | GA = Goals Against |
                GD = Goal Difference | PTS = Points
            </div>

        @else

            <!-- Empty state -->
            <div class="alert alert-info text-center mb-0">
                <h3 class="h5">No League Results Yet</h3>

                <p class="mb-3">
                    Complete some matches and add their scores
                    to see the league standings.
                </p>

                <a href="{{ route('matches') }}" class="btn btn-primary">
                    View Matches
                </a>
            </div>

        @endif

    </div>
</div>

@endsection
