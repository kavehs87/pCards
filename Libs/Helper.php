<?php


namespace kavehs86\rim;


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
}