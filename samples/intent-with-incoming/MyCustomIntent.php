<?php

/**
 * Class MyCustomIntent
 */
class MyCustomIntent implements \Weysan\Alexa\Intents\IntentsInterface
{
    /**
     * @var \Weysan\Alexa\AlexaIncomingRequest
     */
    protected $alexaIncoming;

    public function setAlexaIncomingRequest(\Weysan\Alexa\AlexaIncomingRequest $incmoing)
    {
        $this->alexaIncoming = $incmoing;
        return $this;
    }

    /**
     * @return \Weysan\Alexa\Response\Response
     */
    public function getResponseObject()
    {
        $response = new \Weysan\Alexa\Response\Response();
        $response->addOutput()
            ->setType(\Weysan\Alexa\Response\OutputSpeech::TYPE_PLAIN_TEXT)
            ->setOutput("The user id is : " . $this->alexaIncoming->getUserId());
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