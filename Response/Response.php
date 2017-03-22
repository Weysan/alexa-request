<?php
namespace Weysan\Alexa\Response;


class Response
{
    protected $response = [];

    protected $response_formated = [];

    /**
     * @param OutputSpeech $outputSpeech
     * @return $this
     */
    public function setOutputSpeech(OutputSpeech $outputSpeech)
    {
        $this->response['outputSpeech'] = $outputSpeech;
        $this->response_formated['outputSpeech'] = $outputSpeech->getFormatedData();
        return $this;
    }

    /**
     * @param OutputSpeech $outputSpeech
     * @return $this
     */
    public function setReprompt(OutputSpeech $outputSpeech)
    {
        $this->response['reprompt']['outputSpeech'] = $outputSpeech;
        $this->response_formated['reprompt']['outputSpeech'] = $outputSpeech->getFormatedData();
        return $this;
    }

    /**
     * @return array
     */
    public function getFormatedData()
    {
        return $this->response_formated;
    }

    /**
     * Configure the response to advice Alexa if we want to close the session after the response.
     * @param bool $willEndSession
     * @return $this
     */
    public function willEndSession($willEndSession)
    {
        $this->response['shouldEndSession'] = (bool)$willEndSession;
        $this->response_formated['shouldEndSession'] = (bool)$willEndSession;
        return $this;
    }
}