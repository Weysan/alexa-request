<?php
namespace Weysan\Alexa;

class AlexaOutgoingGenerator
{
    /**
     * @var AlexaIncomingRequest
     */
    protected $incomingRequest;

    protected $dataToSend = [];

    protected $endSession = true;

    public function __construct(AlexaIncomingRequest $incomingRequest)
    {
        $this->incomingRequest = $incomingRequest;
        $this->addIncomingRequestToIntentHandler();
    }

    /**
     * @return $this
     */
    protected function addIncomingRequestToIntentHandler()
    {
        if (method_exists(IntentRegistry::getIntentHandler($this->incomingRequest), "setAlexaIncomingRequest")) {
            IntentRegistry::getIntentHandler($this->incomingRequest)->setAlexaIncomingRequest($this->incomingRequest);
        }
        return $this;
    }

    /**
     * @return bool
     */
    protected function constructResponse()
    {
        $this->dataToSend['version'] = "0.1";

        $this->dataToSend['response'] = [
            'outputSpeech' =>
                IntentRegistry::getIntentHandler($this->incomingRequest)->getResponseObject()->getFormatedData()
        ];

        $this->dataToSend['sessionAttributes'] =
            IntentRegistry::getIntentHandler($this->incomingRequest)->getSessionAttributes()->getCollection();

        $this->dataToSend['shouldEndSession'] = $this->endSession;

        return true;
    }

    /**
     * Configure the response to advice Alexa if we want to close the session after the response.
     * @param bool $willEndSession
     * @return $this
     */
    public function willEndSession($willEndSession)
    {
        $this->endSession = (bool)$willEndSession;
        return $this;
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