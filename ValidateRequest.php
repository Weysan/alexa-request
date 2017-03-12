<?php
namespace Weysan\Alexa;

class ValidateRequest
{
    /**
     * @var AlexaIncomingRequest
     */
    protected $incomingRequest;

    protected $appId;

    public function __construct($appId)
    {
        $this->appId = $appId;
    }

    /**
     * @param AlexaIncomingRequest $incomingRequest
     * @return bool
     */
    public function validateRequest(AlexaIncomingRequest $incomingRequest)
    {
        $this->incomingRequest = $incomingRequest;
        return ($this->isAppIdValid() && $this->isIntentValid());
    }


    protected function isAppIdValid()
    {
        return ($this->incomingRequest->getAppId() == $this->appId);
    }

    protected function isIntentValid()
    {
        return (IntentRegistry::intentExists($this->incomingRequest->getRequestIntent()));
    }
}