<div class="container">
    <div class="row justify-content-center text-white">
        <div>Dealer ({{$game->dealerHand->currentScore()}})</div>
    </div>
    <div class="row justify-content-center text-dark">
        @foreach($game->dealerHand->getCards() as $card)
            @include('elements.card', ['card' => $card])
        @endforeach
    </div>
    <div class="row justify-content-center mt-4 text-white">
        <div>{{$game->playerName}} ({{$game->playerHand->currentScore()}})</div>
    </div>
    <div class="row justify-content-center text-dark">
        @foreach($game->playerHand->getCards() as $card)
            @include('elements.card', ['card' => $card])
        @endforeach
    </div>
</div>
