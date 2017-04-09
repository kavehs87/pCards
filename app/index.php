<?php
include '../vendor/autoload.php';


$players = [
    new \pCards\Core\Player('kaveh'),
    new \pCards\Core\Player('codefish','starter')
];

$game = new \pCards\Rim\Rim();

foreach($players as $player){
    $game->addPlayer($player);
}

$game->prepare();
header('Content-Type: application/json');
echo json_encode($game->reportState());