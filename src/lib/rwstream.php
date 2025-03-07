<?php declare (strict_types = 1);
namespace src\lib;


require_once(__DIR__."/../../../vendor/autoload.php");

class rwStream extends Streams {

    public $stream;
    public $parentType;

    /**
     * @method __construct
     * @param none
     * @return void
     * 
     * common init
     */
    public function __construct() {
        $this->rootType = 'Streams';
        $this->parentType = 'Streams';
        $this->typeOf = 'rwStream';
        $this->buffSize = 16;
        $this->datCntr = 0;
        $this->delim = ';';
        $this->dir = "./";
    }
}
