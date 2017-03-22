<?php
namespace Weysan\Alexa\Response;


class Response
{
    protected $response = [];

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
     * @return array
     */
    public function getFormatedData()
    {
        $formated = $this->response;
        $formated['outputSpeech'] = $formated['outputSpeech']->getFormatedData();
        if (isset($formated['reprompt']['outputSpeech'])) {
            $formated['reprompt']['outputSpeech'] = $formated['reprompt']['outputSpeech']->getFormatedData();
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