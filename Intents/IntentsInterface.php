<?php
namespace Weysan\Alexa\Intents;

use Weysan\Alexa\Response\OutputSpeech;
use Weysan\Alexa\Response\SessionAttributes;

/**
 * Must be implemented by registered Intents
 * @package Weysan\Alexa\Intents
 */
interface IntentsInterface
{
    /**
     * @return OutputSpeech
     */
    public function getResponseObject();

    /**
     * @return SessionAttributes
     */
    public function getSessionAttributes();
}
