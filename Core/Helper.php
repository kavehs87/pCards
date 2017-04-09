<?php


namespace pCards\Core;


class Helper
{
    /**
     * generates error massages
     * @param $message
     * @param string $returnType default/json/html
     */
    public static function error($message, $returnType = 'default')
    {
        $echo = "[error]   ";
        $echo .= "[" . debug_backtrace()[0]->file . "]    ";
        $echo .= "[" . debug_backtrace()[0]->line . "]    ";
        $echo .= "[" . debug_backtrace()[0]->function . "]    ";
        $echo .= "[" . date("y:m:d h:i:s") . ']';
        $echo .= '[' . $message . ']';
        $echo .= PHP_EOL;
        if ($returnType == 'html') {
            $echo = '<pre>' . $echo . '<br/></pre>';
        }
        if ($returnType == 'json') {
            echo json_encode($echo);
        } else {
            echo $echo;
        }
    }

    public static function splitCardName($card)
    {
        $parts = explode('_of_', $card);
        return $parts;
    }

    public static function handToCards($hand)
    {
        foreach ($hand as $i => $_card) {
            $card[$i]['number'] = Helper::splitCardName($_card)[0];
            $card[$i]['type'] = Helper::splitCardName($_card)[1];
        }
        return $card;
    }

    public static function getPreCard($card, $type = null)
    {
        $pre = 0;
        if (is_numeric($card) && $card != 2) {
            $pre = $card - 1;
        }
        if (is_numeric($card) && $card == 2) {
            $pre = 'ace';
        }
        if (!is_numeric($card) && $card == 'ace') {
            $pre = 'king';
        }
        if (!is_numeric($card) && $card == 'king') {
            $pre = 'queen';
        }
        if (!is_numeric($card) && $card == 'queen') {
            $pre = 'jack';
        }
        if (!is_numeric($card) && $card == 'jack') {
            $pre = 10;
        }
        if ($type) {
            $pre = $pre . '_of_' . $type;
        }
        return $pre;
    }
    public static function getNextCard($card, $type = null)
    {
        $next = 0;
        if (is_numeric($card) && $card != 10) {
            $next = $card + 1;
        }
        if (is_numeric($card) && $card == 10) {
            $next = 'jack';
        }
        if (!is_numeric($card) && $card == 'king') {
            $next = 'ace';
        }
        if (!is_numeric($card) && $card == 'ace') {
            $next = '2';
        }
        if (!is_numeric($card) && $card == 'queen') {
            $next = 'king';
        }
        if (!is_numeric($card) && $card == 'jack') {
            $next = 'queen';
        }
        if ($type) {
            $next = $next . '_of_' . $type;
        }
        return $next;
    }
}