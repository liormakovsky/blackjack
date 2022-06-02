<?php

namespace App\Models;

class Card
{
    public const TYPE_HEARTS = 'hearts';
    public const TYPE_SPADES = 'spades';
    public const TYPE_CLUBS = 'clubs';
    public const TYPE_DIAMONDS = 'diamonds';

    public const TYPES = [self::TYPE_HEARTS, self::TYPE_SPADES, self::TYPE_CLUBS, self::TYPE_DIAMONDS];
    public const CARDS = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'JACK', 'QUEEN', 'KING'];
    public const CARD_VALUES = [
        'A' => 11,
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,
        '10' => 10,
        'JACK' => 10,
        'QUEEN' => 10,
        'KING' => 10,
    ];

    private $type;
    private $card;
    private $facing = true;

    /**
     * Card constructor.
     *
     * @param string $type
     * @param string $card
     */
    public function __construct(string $type, string $card)
    {
        $this->card = $card;
        $this->type = $type;
    }

    /**
     *
     * Get card integer value
     *
     * @return int
     */
    public function getValue(): int
    {
        return self::CARD_VALUES[$this->card];
    }

    /**
     * Get card short name,
     *
     * @return string
     */
    public function getShortName(): string
    {
        if (!$this->facing) {
            return "?";
        }

        if (is_numeric($this->card)) {
            //card contains number
            return $this->card;
        } else {
            //card contains Jack,Queen or King
            return substr($this->card, 0, 1);
        }
    }

    /**
     * Type getter
     *
     * @return string
     */
    public function getType(): string
    {
        if (!$this->facing) {
            //card is hidden
            return "?";
        }

        return $this->type;
    }

    /**
     * Card facing setter
     *
     * @param bool $facing
     */
    public function setFacing(bool $facing): void
    {
        $this->facing = $facing;
    }

    /**
     * Card facing getter
     *
     * @return bool
     */
    public function getFacing(): bool
    {
        return $this->facing;
    }
}
