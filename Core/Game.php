<?php


namespace pCards\Core;


class Game
{
    protected $maxPlayers = 4; // for hokm
    protected $maxHandCards = [
//        'all' => 10,
//        'conditions' => [
//            [
//                'tag' => 'starter', // for rim
//                'value' => 11
//            ],
//            [
//                'tag' => 'banker', // for persian 21.
//                'value' => '2' // deals for himself first if count is not 2 (means banker wants to keep the hand)
//            ]
//        ]
    ];
    protected $turnOrder = [
        // so if a player loses we can unset him/her object from here.
    ];
    protected $turn;
    protected $isFresh = true;
    protected $maxFlop = 0; // hokm
    protected $playerCanAddToFlop = true;
    protected $revealMaxFlopOnEmpty = false; // true for rim
    protected $shuffleDeckOnEmpty = true;
    protected $starterTagName = 'starter';

    protected $_deck = null;
    protected $_players = [];
    protected $_flop = [];

    public function __construct()
    {
        $this->_deck = new Deck();

    }

    public function addPlayer(Player $player)
    {
        $this->_players[] = $player;
    }

    public function prepare()
    {
    }

    public function dealHands()
    {
        if (!$this->_deck) {
            throw new GameException("deck object missing");
        }

        foreach ($this->_players as $player) {
            if ($player->getHandCount() != $this->maxHandCards['all']) {
                if ($player->getTag() != null) {
                    if (!empty($this->maxHandCards['conditions'])) {
                        foreach ($this->maxHandCards['conditions'] as $condition) {
                            if ($condition['tag'] == $player->getTag()) {
                                $this->_deck->deal($condition['value'], $player);
                            } else {
                                $this->_deck->deal($this->maxHandCards['all'], $player);
                            }
                        }
                    }
                } else {
                    $this->_deck->deal($this->maxHandCards['all'], $player);
                }
            }
        }
        return null;

    }


    public function setInitialTurns($tag = null)
    {
        if (count($this->_players) < $this->maxPlayers) {
            throw new GameException("maxPlayers Limit not met!" . PHP_EOL . "see: addPlayers()");
        }

        $turns = [];

        // for Rim game, possibly same for other games too.
        foreach ($this->_players as $player) {
            if ($player->getTag() == $tag) {
                $turns[] = [$player->getName() => 1];
                $this->turn = $player->getName();
            }
        }
        $i = count($turns) + 1;
        foreach ($this->_players as $player) {
            if ($player->getTag() != $tag) {
                $turns[] = [$player->getName() => $i++];
            }
        }

        $this->turnOrder = $turns;

    }

    public function isFlopOk()
    {
        if (count($this->_flop) < $this->maxFlop) {
            throw new GameException("maxFlop limit not met", 101);
        }
    }

    public function reportState()
    {
        $players = [];

        foreach ($this->_players as $player) {
            $score = new ScoreRules($player);
            $players[] = [
                'name' => $player->getName(),
                'cards' => $player->getHandState(),
                'score' => $score->getScore()
            ];
        }
        $playerTurn = $this->turn;
        $flop = $this->_flop->getFlop();

        $state = [
            'players' => $players,
            'flop' => $flop,
            'turn' => $playerTurn,
        ];

        return $state;
    }


}