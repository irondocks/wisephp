<?php declare(strict_types = 1);

namespace src\lib;

require_once(__DIR__."/../../../vendor/autoload.php");

class SyntaxError
{
    /**
     * @method __construct
     * @param $message
     * 
     * echo error message
     */
    public function __construct($message)
    {
        echo $message;

        //    trigger_error($this->getCode(), $message, $this->getFile(), $this->getLine());
    }
}
