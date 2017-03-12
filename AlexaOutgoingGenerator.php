<?php
namespace Weysan\Alexa;

class AlexaOutgoingGenerator
{
    /**
     * @var AlexaIncomingRequest
     */
    protected $incomingRequest;

    protected $dataToSend = [];

    public function __construct(AlexaIncomingRequest $incomingRequest)
    {
        $this->incomingRequest = $incomingRequest;
    }

    protected function constructResponse()
    {
        $this->dataToSend['version'] = "0.1";

        $this->dataToSend['response'] = [
            'outputSpeech' =>
                IntentRegistry::getIntentHandler($this->incomingRequest)->getResponseObject()->getFormatedData()
        ];

        $this->dataToSend['sessionAttributes'] = [];

        $this->dataToSend['shouldEndSession'] = true;

        return true;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        $this->constructResponse();

        return $this->dataToSend;
    }
}