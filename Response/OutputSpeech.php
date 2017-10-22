<?php
namespace Weysan\Alexa\Response;

use Weysan\Alexa\Exceptions\UnexpectedOutputTypeException;
use Weysan\Alexa\Exceptions\WrongOutputFormatException;

/**
 * Class OutputSpeech
 * @package Weysan\Alexa\Response
 */
class OutputSpeech
{
    const TYPE_PLAIN_TEXT = "PlainText";

    const TYPE_SSML = "SSML";

    protected $type;

    protected $output;

    /**
     * @param string $type
     * @return $this
     * @throws UnexpectedOutputTypeException
     */
    public function setType($type)
    {
        if ($type !== self::TYPE_PLAIN_TEXT && $type !== self::TYPE_SSML) {
            throw new UnexpectedOutputTypeException($type);
        }

        $this->type = $type;

        return $this;
    }

    /**
     * @param string $output
     * @return $this
     * @throws WrongOutputFormatException
     */
    public function setOutput($output)
    {
        if (!is_string($output)) {
            throw new WrongOutputFormatException($output);
        }
        $this->output = $output;
        return $this;
    }

    /**
     * @param array $formatedData
     * @return array
     * @throws UnexpectedOutputTypeException
     */
    protected function addFormatedOutput(array $formatedData)
    {
        switch ($this->type) {
            case self::TYPE_SSML:
                $formatedData['ssml'] = $this->output;
                break;
            case self::TYPE_PLAIN_TEXT:
                $formatedData['text'] = $this->output;
                break;
            default:
                throw new UnexpectedOutputTypeException($this->type);
        }

        return $formatedData;
    }

    /**
     * @return array
     * @throws WrongOutputFormatException
     */
    public function getFormatedData()
    {
        if (empty($this->output)) {
            throw new WrongOutputFormatException($this->output);
        }

        $formated = [
            'type' => $this->type
        ];

        return $this->addFormatedOutput($formated);
    }
}