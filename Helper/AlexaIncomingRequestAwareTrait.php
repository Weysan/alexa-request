<?php
namespace Weysan\Alexa\Helper;

use Weysan\Alexa\AlexaIncomingRequest;

/**
 * DI for AlexaIncomingRequest instance
 * @package Weysan\Alexa\Helper
 */
trait AlexaIncomingRequestAwareTrait
{
    /**
     * @var AlexaIncomingRequest|null
     */
    protected $alexaIncomingRequest;

    /**
     * @param AlexaIncomingRequest $alexaIncomingRequest
     * @return $this
     */
    public function setAlexaIncomingRequest(AlexaIncomingRequest $alexaIncomingRequest)
    {
        $this->alexaIncomingRequest = $alexaIncomingRequest;
        return $this;
    }
}