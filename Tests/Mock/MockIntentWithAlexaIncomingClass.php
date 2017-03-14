<?php
namespace Weysan\Alexa\Tests\Mock;

use Weysan\Alexa\Helper\AlexaIncomingRequestAwareTrait;
use Weysan\Alexa\Intents\IntentsInterface;

/**
 * The unique purpose of that class is to mock an IntentsInterface Class using AlexaIncomingRequest trait
 * @package Weysan\Alexa\Tests\Mock
 */
abstract class MockIntentWithAlexaIncomingClass implements IntentsInterface
{
    use AlexaIncomingRequestAwareTrait;
}
