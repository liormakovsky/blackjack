<div class="container">
    <div class="row justify-content-center">
        <div>Dealer Hand ({{$game->dealerHand->currentScore()}})</div>
    </div>
    <div class="row justify-content-center">
        @foreach($game->dealerHand->getCards() as $card)
            @include('elements.card', ['card' => $card])
        @endforeach
    </div>
    <div class="row justify-content-center mt-4">
        <div>Player Hand ({{$game->playerHand->currentScore()}})</div>
    </div>
    <div class="row justify-content-center">
        @foreach($game->playerHand->getCards() as $card)
            @include('elements.card', ['card' => $card])
        @endforeach
    </div>
</div>
