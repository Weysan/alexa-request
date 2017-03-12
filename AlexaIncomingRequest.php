<?php
namespace Weysan\Alexa;

use Symfony\Component\HttpFoundation\Request;

class AlexaIncomingRequest
{
    protected $requestBody = array();

    public function __construct(Request $request)
    {
        $this->requestBody = json_decode($request->getContent(), true);
    }

    public function getAppId()
    {
        return $this->requestBody['session']['application']['applicationId'];
    }

    public function getSessionId()
    {
        return $this->requestBody['session']['sessionId'];
    }

    public function getUserId()
    {
        return $this->requestBody['user']['userId'];
    }

    public function getVersion()
    {
        return $this->requestBody['version'];
    }

    public function getRequestType()
    {
        return $this->requestBody['request']['type'];
    }

    public function getRequestIntent()
    {
        return $this->requestBody['request']['intent']['name'];
    }
}