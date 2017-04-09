<?php


namespace pCards\Core;


class ScoreRules
{
    protected $_scores = [
        'ace' => 14,
        'king' => 13,
        'queen' => 12,
        'jack' => 11,
        '10' => 10,
        '9' => 9,
        '8' => 8,
        '7' => 7,
        '6' => 6,
        '5' => 5,
        '4' => 4,
        '3' => 3,
        '2' => 2,
    ];
    protected $_player;
    protected $winnerRule = [
        [
            'rule' => 'score',
            'value' => 0
        ],
    ];

    public function __construct(Player $player)
    {
        $this->_player = $player;
    }

    public function getScore()
    {
        $this->checkSimilarity();
        $hand = $this->_player->getHandState();
        $card = Helper::handToCards($hand);

        return $card;
    }

    protected function checkSimilarity()
    {
        $hand = $this->_player->getHandState();
        var_dump($hand);
        $cards = Helper::handToCards($hand);
        $nextLevels = [];
        foreach ($cards as $card) {

            $next = Helper::getNextCard($card['number']);
            $nextLike = preg_grep("/^{$next}_of_*/", $hand);
            $nextLike = end($nextLike);
            $_nextLevels = [$card['number'] . '_of_' . $card['type']];
            while (!empty($nextLike)) {
                if (is_array($nextLike)) {
                    $nextLike = reset($nextLike);
                }
                $_nextLevels[] = $nextLike;
                $bits = explode('_of_', $nextLike);
                $next = Helper::getNextCard($bits[0]);
                $nextLike = preg_grep("/^{$next}_of_*/", $hand);
            }
            if (count($_nextLevels) > 3) {
                $nextLevels[] = $_nextLevels;
            }

            $like = preg_grep("/^{$card['number']}_of_*/", $hand);
            $matches = [];
            if (count($like) >= 3) {
                $matches[] = $like;
            }

        }
        echo '************* Matches **************' . PHP_EOL;
        var_dump($matches);
        echo '************* Digits **************' . PHP_EOL;
        var_dump($nextLevels);
        die();
    }

}