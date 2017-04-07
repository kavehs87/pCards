<?php


namespace kavehs86\rim;


class Player
{
    protected $name;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    protected $tag;

    public function getTag()
    {
        return $this->tag;
    }

    public function setTag($tag)
    {
        $this->tag = $tag;
        return $this;
    }

    protected $turn = false;
    protected $_handState = [];

    public function __construct($name, $tag = null)
    {
        $this->name = $name;
        $this->tag = $tag;
    }

    public function getHandCount()
    {
        return count($this->_handState);
    }

    public function getHandState()
    {
        return $this->_handState;
    }

    public function setHandState($handState)
    {
        $this->_handState = $handState;
        return $this;
    }

    public function setTurn($turn)
    {
        return $this->turn = $turn;
    }

    public function getTurn()
    {
        return $this->turn;
    }

    public function gainCard(Array $cards)
    {
        $this->_handState = array_merge($this->_handState, $cards);
    }

    public function loseCard(Array $cards)
    {
        foreach ($cards as $card) {
            $key = array_search($card, $this->_handState);
            if ($key !== false) {
                unset($this->_handState[$key]);
            }
        }
    }


}