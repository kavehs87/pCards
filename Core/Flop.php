<?php


namespace pCards\Core;


class Flop
{
    protected $_flop = [];

    public function getFlop()
    {
        return $this->_flop;
    }

    public function setFlop($flopState)
    {
        $this->_flop = $flopState;
        return $this;
    }

    public function __construct(Array $gainCards = [])
    {
        if (!empty($gainCards)) {
            $this->gainCard($gainCards);
        }
    }

    public function gainCard(Array $cards)
    {
        $this->_flop = array_merge($this->_flop, $cards);
    }

    public function loseCard(Array $cards)
    {
        foreach ($cards as $card) {
            $key = array_search($card, $this->_flop);
            if ($key !== false) {
                unset($this->_flop[$key]);
            }
        }
    }
}