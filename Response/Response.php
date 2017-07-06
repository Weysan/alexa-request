<?php
namespace Weysan\Alexa\Response;


use Weysan\Alexa\Response\Cards\CardInterface;
use Weysan\Alexa\Response\Cards\SimpleCard;

class Response
{
    protected $response = [];

    public function __construct()
    {
        //default value
        $this->willEndSession(true);
    }

    /**
     * @return OutputSpeech
     */
    public function addOutput()
    {
        $outputSpeech = new OutputSpeech();
        $this->response['outputSpeech'] = $outputSpeech;
        return $outputSpeech;
    }

    /**
     * @return OutputSpeech
     */
    public function addReprompt()
    {
        $outputSpeech = new OutputSpeech();
        $this->response['reprompt']['outputSpeech'] = $outputSpeech;
        return $outputSpeech;
    }

    /**
     * @param string $type
     * @return bool|CardInterface
     */
    public function addCard($type = SimpleCard::TYPE)
    {
        $card = new Card();
        $cardInterface = $card->getType($type);
        $this->response['card'] = $cardInterface;
        return $cardInterface;
    }

    /**
     * @return array
     */
    public function getFormatedData()
    {
        $formated = $this->response;
        $formated['outputSpeech'] = $formated['outputSpeech']->getFormatedData();
        if (isset($formated['reprompt']['outputSpeech'])) {
            $formated['reprompt']['outputSpeech'] = $formated['reprompt']['outputSpeech']->getFormatedData();
        }
        if (isset($formated['card']) && $formated['card'] instanceof CardInterface) {
            $formated['card'] = $formated['card']->getFormatedData();
        }
        return $formated;
    }

    /**
     * Configure the response to advice Alexa if we want to close the session after the response.
     * @param bool $willEndSession
     * @return $this
     */
    public function willEndSession($willEndSession)
    {
        $this->response['shouldEndSession'] = (bool)$willEndSession;
        return $this;
    }
}