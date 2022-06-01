<?php

namespace App\Games\Blackjack\Models;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class Game
{
    public const BLACKJACK_VALUE = 21;

    public const PLAYER = 'PLAYER';
    public const DEALER = 'DEALER';
    public const DRAW = 'DRAW';

    public const GAME_STARTED = 'GAME_STARTED';
    public const GAME_ENDED = 'GAME_ENDED';

    /**
     * @var string
     */
    public $playerName;

    /**
     * @var Carbon
     */
    public $delay;

    /**
     * @var Dealer
     */
    public $dealer;

    /**
     * @var Collection
     */
    public $deck;

    /**
     * @var Hand
     */
    public $playerHand;

    /**
     * @var Hand
     */
    public $dealerHand;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $winner;

    /**
     * Game constructor.
     *
     * @param string $playerName
     * @param Carbon $delay
     */
    public function __construct(string $playerName, Carbon $delay)
    {
        $this->playerName = $playerName;
        $this->delay = $delay;
    }

    /**
     * This is for start a new round
     */
    public function start()
    {
        $this->deck = Deck::generate(6);

        $this->dealerHand = new Hand();
        $this->playerHand = new Hand();

        $this->dealer = new Dealer($this);

        //take 2 cards for player
        $this->dealer->hitPlayer();
        $this->dealer->hitPlayer();

        //take 2 cards for dealer
        $this->dealer->hitDealer(false);
        $this->dealer->hitDealer();

        $this->status = self::GAME_STARTED;
        $this->winner = null;
    }

    /**
     * This will check player is bust;
     *
     * @return bool
     */
    public function checkPlayerBust(): bool
    {
        if ($this->playerHand->currentScore() > self::BLACKJACK_VALUE) {
            $this->winner = self::DEALER;
            $this->status = self::GAME_ENDED;
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
        $dealerBust = $this->dealerHand->currentScore() > self::BLACKJACK_VALUE;
        $playerBust = $this->playerHand->currentScore() > self::BLACKJACK_VALUE;
        $playerHasBetterHand = $this->playerHand->currentScore() > $this->dealerHand->currentScore();

        if ($dealerBust || ($playerHasBetterHand && !$playerBust)) {
            $this->winner = self::PLAYER;
        } elseif ($this->dealerHand->currentScore() === $this->playerHand->currentScore()) {
            $this->winner = self::DRAW;
        } else {
            $this->winner = self::DEALER;
        }

        $this->status = self::GAME_ENDED;
    }
}
