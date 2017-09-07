<?php
namespace Weysan\Alexa;

use Psr\Http\Message\ServerRequestInterface;
use Weysan\Alexa\Response\SessionAttributes;

class AlexaIncomingRequest
{
    protected $requestBody = array();

    protected $sessionAttributes;

    public function __construct(ServerRequestInterface $request)
    {
        $this->requestBody = json_decode($request->getBody()->getContents(), true);
        $this->sessionAttributes = new SessionAttributes();
        $this->parseSessionAttributes();
    }

    /**
     * @return $this
     */
    protected function parseSessionAttributes()
    {
        if (isset($this->requestBody['session']['attributes'])) {
            foreach ($this->requestBody['session']['attributes'] as $key => $value) {
                $this->sessionAttributes->addAttribute($key, $value);
            }
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getAppId()
    {
        return $this->requestBody['session']['application']['applicationId'];
    }

    /**
     * @return SessionAttributes
     */
    public function getSessionAttributes()
    {
        return $this->sessionAttributes;
    }

    /**
     * @return string
     */
    public function getSessionId()
    {
        return $this->requestBody['session']['sessionId'];
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->requestBody['session']['user']['userId'];
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->requestBody['version'];
    }

    /**
     * @return string
     */
    public function getRequestType()
    {
        return $this->requestBody['request']['type'];
    }

    /**
     * @return string
     */
    public function getRequestIntent()
    {
        return $this->requestBody['request']['intent']['name'];
    }

    /**
     * @param string $slotName
     * @return string|false
     */
    public function getIntentSlotValue($slotName)
    {
        $slot = isset($this->requestBody['request']['intent']['slots'])?
            $this->requestBody['request']['intent']['slots']:[];

        return isset($slot[$slotName]['value']) ? $slot[$slotName]['value'] : false;
    }
}
