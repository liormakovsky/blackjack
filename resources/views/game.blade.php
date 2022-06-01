@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('status'))
                    <div class="alert alert-danger">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        </div>

        @if($game && $game->status === \App\Games\Blackjack\Models\Game::GAME_ENDED)
            <div class="container justify-content-center mb-3">
                <div class="row justify-content-center">
                    WINNER {{$game->winner}}
                </div>
                <div class="row justify-content-center">
                    Round Time: {{$game->delay->diff(now())->s}} seconds
                </div>
            </div>
    @endif

    @if(isset($game))
        @include('board')
        @include('elements.actions')
    @else
        @include('forms.start')


    @endif

@endsection
