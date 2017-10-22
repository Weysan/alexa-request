<?php
namespace Weysan\Alexa\Exceptions;

use Weysan\Alexa\Response\OutputSpeech;

/**
 * Class UnexpectedOutputTypeException
 * @package Weysan\Alexa\Exceptions
 */
class UnexpectedOutputTypeException extends AlexaRequestException
{
    public function __construct($wrong_type)
    {
        $message = "Wrong type '$wrong_type' used. Should be " . OutputSpeech::TYPE_PLAIN_TEXT
            . ' or ' . OutputSpeech::TYPE_SSML;
        parent::__construct($message);
    }
}