<?php


namespace kavehs86\rim;

use kavehs86\rim\GameException;

class Deck
{
    protected $_numbers = [
        'ace',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        'jack',
        'queen',
        'king'
    ];

    protected $_types = [
        'spades',
        'hearts',
        'diamonds',
        'clubs'
    ];

    protected $_deckState = null;

    /**
     * builds 52 cards and shuffles them into $_deckState (pass cards to $excludeList Array to make custom deck)
     * @param array $excludeList
     */
    public function buildFreshDeck(Array $excludeList = [])
    {
        $this->_deckState = '';

        foreach ($this->_numbers as $number) {
            foreach ($this->_types as $type) {
                $card = $number . '_of_' . $type;
                if (!in_array($card, $excludeList)) {
                    $this->_deckState[] = $card;
                }
            }
        }
    }

    /**
     * deals $cardsCount amount of cards from the $_deckState array
     * @param $cardsCount
     * @param Player $player
     * @return array|null
     * @throws \kavehs86\rim\GameException
     */
    public function deal($cardsCount,Player $player = null)
    {
        if ($cardsCount > count($this->_deckState)) {
            throw new GameException("can't deal more than " . count($this->_deckState) . " cards! (" . $cardsCount . " requested)");
        }

        $picked = array_rand($this->_deckState, $cardsCount);
        $cards = null;
        if (is_array($picked)) {
            foreach ($picked as $p) {
                $cards[] = $this->_deckState[$p];
                unset($this->_deckState[$p]);
            }
        } else {
            $cards[] = $this->_deckState[$picked];
            unset($this->_deckState[$picked]);
        }
        if ($player != null){
            $player->gainCard($cards);
            return $this;
        }
        return $cards;
    }


    /**
     * @return null
     */
    public function getDeckState()
    {
        return $this->_deckState;
    }

    /**
     * @param null $deckState
     */
    public function setDeckState($deckState)
    {
        $this->_deckState = $deckState;
    }

}