<?php

/**
 * Class MyCustomIntent
 */
class MyCustomIntent implements \Weysan\Alexa\Intents\IntentsInterface
{
    /**
     * @return \Weysan\Alexa\Response\Response
     */
    public function getResponseObject()
    {
        $response = new \Weysan\Alexa\Response\Response();
        $response->addOutput()
            ->setType(\Weysan\Alexa\Response\OutputSpeech::TYPE_PLAIN_TEXT)
            ->setOutput("Hello World");
        return $response;
    }

    /**
     * @return \Weysan\Alexa\Response\SessionAttributes
     */
    public function getSessionAttributes()
    {
        return new \Weysan\Alexa\Response\SessionAttributes();
    }
}