<?php
namespace Weysan\Alexa;

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
        $this->response = new Response();
        $this->response->willEndSession(true);
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

        $this->response->setOutputSpeech(IntentRegistry::getIntentHandler($this->incomingRequest)->getResponseObject());

        $this->dataToSend['response'] = $this->response->getFormatedData();

        $this->dataToSend['sessionAttributes'] =
            IntentRegistry::getIntentHandler($this->incomingRequest)->getSessionAttributes()->getCollection();

        return true;
    }

    /**
     * Configure the response to advice Alexa if we want to close the session after the response.
     * @param bool $willEndSession
     * @return $this
     */
    public function willEndSession($willEndSession)
    {
        $this->response->willEndSession($willEndSession);
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