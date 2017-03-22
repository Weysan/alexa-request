<?php
namespace Weysan\Alexa;

use Weysan\Alexa\Response\OutputSpeech;
use Weysan\Alexa\Response\Response;

class AlexaOutgoingGenerator
{
    /**
     * @var AlexaIncomingRequest
     */
    protected $incomingRequest;

    protected $dataToSend = [];

    protected $endSession = true;

    /**
     * @var Response
     */
    protected $response;

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

        $this->dataToSend['response'] = IntentRegistry::getIntentHandler($this->incomingRequest)->getResponseObject()->getFormatedData();

        $this->dataToSend['sessionAttributes'] =
            IntentRegistry::getIntentHandler($this->incomingRequest)->getSessionAttributes()->getCollection();

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