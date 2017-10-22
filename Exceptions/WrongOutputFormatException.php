<?php
namespace Weysan\Alexa\Exceptions;

/**
 * Class WrongOutputFormatException
 * @package Weysan\Alexa\Exceptions
 */
class WrongOutputFormatException extends \Exception
{
    public function __construct($wrong_output)
    {
        $message = "Output text should be a string, " . gettype($wrong_output) . ' given';
        parent::__construct($message);
    }
}