<?php declare(strict_types = 1);

namespace src\lib;

require_once(__DIR__."/../../../vendor/autoload.php");

class Container
{
    // Type Specifications
    public $typeOf;
    public $rootType;
    // $this->strict >= 1 to Use IndexExceptions
    // in Containers (use_strict($bool))
    public $strict;

    /**
     * @method __construct
     * 
	 * common init
	 * 
     */
    public function __construct()
    {
        $this->strict = false;
    }

    /**
     * @method using_strict
     * @param toggle
     * 
     * Strict IndexException Error Calling
	 * 
     */
    public function use_strict(bool $bool = false)
    {
        if ($bool != 0) {
            $this->strict = true;
        } else {
            $this->strict = 0;
        }
        return $this->strict;
    }
}
