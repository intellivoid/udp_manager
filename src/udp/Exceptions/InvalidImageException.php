<?php


    namespace udp\Exceptions;

    use Exception;

    /**
     * Class InvalidImageException
     * @package udp\Exceptions
     */
    class InvalidImageException extends Exception
    {
        /**
         * InvalidImageException constructor.
         * @param $message
         */
        public function __construct($message)
        {
            parent::__construct($message);
        }
    }