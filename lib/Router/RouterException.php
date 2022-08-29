<?php


namespace Buki\Router;

use Exception;

class RouterException
{
    /**
     * @var bool $debug Debug mode
     */
    public static $debug = false;

    /**
     * Create Exception Class.
     *
     * @param $message
     *
     * @return string
     * @throws Exception
     */
    public function __construct($message)
    {
        if (self::$debug) {
            throw new Exception($message, 1);
        } else {
              redirect(base_url()."404");
        }
    }
}
