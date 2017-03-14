<?php
namespace Weysan\Alexa\Response;

class OutputSpeech
{
    const TYPE_PLAIN_TEXT = "PlainText";

    const TYPE_SSML = "SSML";

    protected $type;

    protected $output;

    public function setType($type)
    {
        if ($type !== self::TYPE_PLAIN_TEXT && $type !== self::TYPE_SSML) {
            return false;
        }

        $this->type = $type;

        return true;
    }

    public function setOutput($output)
    {
        if (!is_string($output)) {
            return false;
        }
        $this->output = $output;
        return true;
    }

    /**
     * @param array $formatedData
     * @return array|bool
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
                $formatedData = [];
                break;
        }

        return !empty($formatedData)?$formatedData:false;
    }

    /**
     * @return array|bool
     */
    public function getFormatedData()
    {
        if (empty($this->output)) {
            return false;
        }

        $formated = [
            'type' => $this->type
        ];

        return $this->addFormatedOutput($formated);
    }
}