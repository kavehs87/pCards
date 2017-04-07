<?php
include 'Libs/GameException.php';
include 'Libs/Player.php';
include 'Libs/Flop.php';
include 'Libs/Deck.php';
include 'Libs/Game.php';
include 'Libs/Helper.php';

//$deck = new \kavehs86\rim\Deck();
//$deck->buildFreshDeck([
//    '10-S',
//    'K-H'
//]);


//$player = new \kavehs86\rim\Player('kaveh');
//$player->gainCard([
//    'A-S',
//    '8-H',
//    'A-H'
//]);
//$player->loseCard([
//    'A-H',
//    'A-S'
//]);
//var_dump($player->getHandState());



$game = new \kavehs86\rim\Game();

$kaveh = new \kavehs86\rim\Player('kaveh');
//$kaveh->setTag('starter');
$game->addPlayer($kaveh);

$codefish = new \kavehs86\rim\Player('codefish');
$codefish->setTag('starter');
$game->addPlayer($codefish);

var_dump($game->prepare());