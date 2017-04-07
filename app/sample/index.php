<?php

include '../../Config.php';
include '../../Libs/GameException.php';
include '../../Libs/Player.php';
include '../../Libs/Flop.php';
include '../../Libs/Deck.php';
include '../../Libs/Game.php';
include '../../Libs/Helper.php';

$players = [
    new \kavehs86\rim\Player('kaveh'),
    new \kavehs86\rim\Player('codefish','starter')
];

$game = new \kavehs86\rim\Game();
foreach($players as $player){
    $game->addPlayer($player);
}

$game->prepare();
header('Content-Type: application/json');
echo json_encode($game->reportState());