<?php
namespace Weysan\Alexa\Tests\Mock;

use Weysan\Alexa\Helper\AlexaIncomingRequestAwareTrait;
use Weysan\Alexa\Intents\IntentsInterface;
use Weysan\Alexa\Response\OutputSpeech;
use Weysan\Alexa\Response\SessionAttributes;

/**
 * The unique purpose of that class is to mock an IntentsInterface Class using AlexaIncomingRequest trait
 * @package Weysan\Alexa\Tests\Mock
 */
class MockIntentWithAlexaIncomingClass implements IntentsInterface
{
    use AlexaIncomingRequestAwareTrait;

    public function getSessionAttributes()
    {
        return new SessionAttributes();
    }

    public function getResponseObject()
    {
        return new OutputSpeech();
    }
}
