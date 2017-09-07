<?php
namespace Weysan\Alexa;

use Weysan\Alexa\Intents\IntentsInterface;

/**
 * Register app Intents handler
 * @package Weysan\Alexa
 */
class IntentRegistry
{
    protected static $intents = [];

    /**
     * @param string $intentName
     * @param IntentsInterface $intentInstance
     * @return bool
     */
    public static function registerIntentHandler($intentName, IntentsInterface $intentInstance)
    {
        self::$intents[$intentName] = $intentInstance;
        return true;
    }

    /**
     * @param AlexaIncomingRequest $incomingRequest
     * @return IntentsInterface
     * @throws \Exception
     */
    public static function getIntentHandler(AlexaIncomingRequest $incomingRequest)
    {
        if (!isset(self::$intents[$incomingRequest->getRequestIntent()])) {
            throw new \Exception("Sorry, I don't understand you!");
        }

        return self::$intents[$incomingRequest->getRequestIntent()];
    }

    /**
     * Unregister an existing intent
     * @param string $intentName
     * @return bool
     */
    public static function unregisterIntentHandler($intentName)
    {
        if (self::intentExists($intentName)) {
            unset(self::$intents[$intentName]);
            return true;
        }
        return false;
    }

    /**
     * @param string $intentName
     * @return bool
     */
    public static function intentExists($intentName)
    {
        return (isset(self::$intents[$intentName]));
    }
}