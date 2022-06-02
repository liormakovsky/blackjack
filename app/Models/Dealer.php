<?php

namespace App\Models;

class Dealer
{

    private $game;

    /**
     * Dealer constructor.
     *
     * @param Game $game
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    /**
     * Hit a card for player
     */
    public function hitPlayer()
    {
        $this->game->playerHand->addCard($this->game->deck->pop());
    }

    /**
     * Hit a card for dealer
     *
     * @param bool $facing
     */
    public function hitDealer(bool $facing = true)
    {
        $this->game->dealerHand->addCard($this->game->deck->pop(), $facing);
    }

    /**
     * Hit cards until to dealer max value (17)
     */
    public function hitDealerUntilToEnd()
    {   
        //display dealer hidden card
        $this->game->dealerHand->faceUpCard();

        while ($this->game->dealerHand->currentScore() < 17) {
            //dealer score is less than 17, hit dealer
            $this->hitDealer();
        }
        $this->game->calculateWinner();
    }
}
