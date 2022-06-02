<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class Game
{  
    public $playerName;
    public $startTime;
    public $dealer;
    public $deck;
    public $playerHand;
    public $dealerHand;
    public $status;
    public $winner;

    /**
     * Game constructor.
     *
     * @param string $playerName
     * @param Carbon $startTime
     */
    public function __construct(string $playerName, Carbon $startTime)
    {
        $this->playerName = $playerName;
        $this->startTime = $startTime;
    }

    /**
     * This is for start a new round
     */
    public function start()
    {
        //generate 6 decks of cards that includes 312 singles cards
        $this->deck = Deck::generate(6);

        //create new hands instances and save it as prop
        $this->dealerHand = new Hand();
        $this->playerHand = new Hand();

        $this->dealer = new Dealer($this);

        //take 2 cards for player
        $this->dealer->hitPlayer();
        $this->dealer->hitPlayer();

        //take 2 cards for dealer
        $this->dealer->hitDealer(false);
        $this->dealer->hitDealer();

        $this->status = 'GAME_STARTED';
        $this->winner = null;
    }

    /**
     * This will check player is bust;
     *
     * @return bool
     */
    public function checkPlayerBust(): bool
    {
        if ($this->playerHand->currentScore() > 21) {
            //player busted
            $this->winner = 'DEALER';
            $this->status = 'GAME_ENDED';
            //display dealer hidden card
            $this->dealerHand->faceUpCard();
            return true;
        }
        return false;
    }

    /**
     *  Calculate winner
     */
    public function calculateWinner(): void
    {
        $dealerBust = $this->dealerHand->currentScore() > 21;
        $playerBust = $this->playerHand->currentScore() > 21;
        $playerHasBetterHand = $this->playerHand->currentScore() > $this->dealerHand->currentScore();

        if ($dealerBust || ($playerHasBetterHand && !$playerBust)) {
            $this->winner = 'YOU';
        } elseif ($this->dealerHand->currentScore() === $this->playerHand->currentScore()) {
            $this->winner = 'DRAW';
        } else {
            $this->winner = 'DEALER';
        }

        $this->status = 'GAME_ENDED';
    }
}
