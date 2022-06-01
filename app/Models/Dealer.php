<?php

namespace App\Models;

class Dealer
{
    private const DEALER_MAX_VALUE = 17;

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
        $this->game->dealerHand->faceUpCard();

        while ($this->game->dealerHand->currentScore() < self::DEALER_MAX_VALUE) {
            $this->hitDealer();
        }
        $this->game->calculateWinner();
    }
}
