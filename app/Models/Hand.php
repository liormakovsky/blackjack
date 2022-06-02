<?php

namespace App\Models;

class Hand
{
    private const ACE_MIN_VALUE = 1;
    private const ACE_MAX_VALUE = 11;

    private $cards;

    /**
     * Add card to hand
     *
     * @param Card $card
     * @param bool $facing
     */
    public function addCard(Card $card, $facing = true): void
    {
        $card->setFacing($facing);
        $this->cards[] = $card;
    }

    /**
     * Cards getter
     *
     * @return Card[]
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * Cards setter
     *
     * @param array $cards
     */
    public function setCards(array $cards): void
    {
        $this->cards = $cards;
    }

    /**
     * Get card values
     *
     * @return array
     */
    public function values(): array
    {
        $values = [];
        foreach ($this->cards as $card) {
            if ($card->getFacing()) {
                //the card ins't hidden
                $values[] = $card->getValue();
            }
        }
        return $values;
    }

    /**
     * Calculate current hand score
     *
     * @return int
     */
    public function currentScore()
    {
        $values = collect($this->values());

        //Sum without aces
        $sum = $values
            ->filter(function ($value) {
                return $value !== self::ACE_MAX_VALUE;
            })
            ->flatten()
            ->sum();

        //Count aces
        $aceCount = $values->filter(function ($value) {
            return $value === self::ACE_MAX_VALUE;
        })->count();

        if (!$aceCount) {
            //no aces found
            return $sum;
        } elseif ($aceCount >= 2) {
            // if there is a lot of ace, add them as 1
            return $sum + self::ACE_MIN_VALUE * 2;
        } elseif ($sum < self::ACE_MAX_VALUE) {
            //the sum is less than 11 -> add 11
            return $sum + self::ACE_MAX_VALUE;
        } else {
            //the sum is bigger than 11 -> add 1 
            return $sum + self::ACE_MIN_VALUE;
        }
    }

    /**
     *  Flip the card
     */
    public function faceUpCard()
    {
        $this->cards[0]->setFacing(true);
    }
}
