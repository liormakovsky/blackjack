@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center text-white">
            <div class="col-md-8">
                @if (session('status'))
                    <div class="alert alert-danger">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        </div>

        @if($game && $game->status === "GAME_ENDED")
            <div class="container justify-content-center mb-3 text-white">
                <div class="row justify-content-center">
                {{$game->winner}} WON 
                </div>
                <div class="row justify-content-center">
                    Round Time: {{$game->startTime->diff(now())->s}} seconds
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
