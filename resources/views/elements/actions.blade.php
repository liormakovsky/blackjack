<div class="container mt-3">
    <div class="row justify-content-center">

        @if($game->status === \App\Games\Blackjack\Models\Game::GAME_STARTED)

            <a class="btn btn-primary mr-2"
               role="button"
               href="{{ route("blackjack.hit")}}">
                Hit
            </a>

            <a class="btn btn-primary mr-2"
               role="button"
               href="{{ route("blackjack.stay")}}">
                Stay
            </a>
        @endif

        @if($game->status === \App\Games\Blackjack\Models\Game::GAME_ENDED)
            <a class="btn btn-success mr-2"
               role="button"
               href="{{route("blackjack.next")}}">
                Next Round
            </a>
        @endif

    </div>
</div>
