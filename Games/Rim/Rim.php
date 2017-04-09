<?php


namespace pCards\Rim;

use pCards\Core\Flop;
use pCards\Core\Game;
use pCards\Core\GameException;
use pCards\Core\Helper;

class Rim extends Game
{
    protected $maxPlayers = 2;
    protected $maxHandCards = [
        'all' => 10,
        'conditions' => [ // for Rim
            [
                'tag' => 'starter',
                'value' => 11
            ]
        ]
    ];
    protected $maxFlop = 1;
    protected $revealMaxFlopOnEmpty = true;

    public function prepare()
    {
        if ($this->isFresh) {
            try {
                $this->_deck->buildFreshDeck();
                $this->setInitialTurns($this->starterTagName);
                $this->isFlopOk();
            } catch (GameException $ex) {
                if ($ex->getCode() == 101) {
                    $this->_flop = new Flop($this->_deck->deal($this->maxFlop));
                } else {
                    return Helper::error($ex->getMessage());
                }
            }
            $this->dealHands();
        } else {
//            load states from db
//            $this->_deck->setDeckState($deckState);
        }
        return $this;
    }



}