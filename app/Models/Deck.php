<?php

namespace App\Models;

use Illuminate\Support\Collection;

class Deck
{
    /**
     * @var array
     */
    private $cards;

    /**
     * Deck constructor.
     */
    public function __construct()
    {
        foreach (Card::TYPES as $type) {
            foreach (Card::CARDS as $card) {
                //generate new single card
                $this->cards[] = new Card($type, $card);
            }
        }
        $this->cards = collect($this->cards)->shuffle()->all();
    }

    /**
     * Cards getter
     *
     * @return array
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * Generate decks (6 deck - 312 cards)
     * @param int $count
     * @return Collection
     */
    public static function generate(int $count)
    {
        $cards = [];
        for ($i = 0; $i < $count; $i++) {
            //create new deck with 52 cards
            $deck = new self();
            //push the deck into the cards array
            $cards[] = $deck->getCards();
        }
        return collect($cards)->flatten();
    }
}
