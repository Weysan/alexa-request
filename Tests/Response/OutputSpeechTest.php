<?php
namespace Weysan\Alexa\Tests\Response;

use PHPUnit\Framework\TestCase;
use Weysan\Alexa\Response\OutputSpeech;

class OutputSpeechTest extends TestCase
{
    public function testPlainTextOutput()
    {
        $outputSpeech = new OutputSpeech();
        $outputSpeech->setType(OutputSpeech::TYPE_PLAIN_TEXT);
        $this->assertNotFalse($outputSpeech->setOutput("Simple text to return"));

        $this->assertEquals([
            "type" => "PlainText",
            "text" => "Simple text to return"
        ], $outputSpeech->getFormatedData());
    }

    public function testSSMLOutput()
    {
        $outputSpeech = new OutputSpeech();
        $outputSpeech->setType(OutputSpeech::TYPE_SSML);
        $this->assertNotFalse($outputSpeech->setOutput("Text SSML format."));

        $this->assertEquals([
            "type" => "SSML",
            "ssml" => "Text SSML format."
        ], $outputSpeech->getFormatedData());
    }

    /**
     * @expectedException Weysan\Alexa\Exceptions\WrongOutputFormatException
     */
    public function testWrongDataToOutput()
    {
        $outputSpeech = new OutputSpeech();
        $outputSpeech->setType(OutputSpeech::TYPE_SSML);
        $outputSpeech->setOutput([
            'no matter'
        ]);
    }

    /**
     * @expectedException Weysan\Alexa\Exceptions\WrongOutputFormatException
     */
    public function testEmptyDataException()
    {
        $outputSpeech = new OutputSpeech();
        $outputSpeech->getFormatedData();
    }

    /**
     * @expectedException Weysan\Alexa\Exceptions\UnexpectedOutputTypeException
     */
    public function testWrongOutputType()
    {
        $outputSpeech = new OutputSpeech();
        $outputSpeech->setType("bla bla bla");
    }

    /**
     * @expectedException Weysan\Alexa\Exceptions\UnexpectedOutputTypeException
     */
    public function testWrongOutputTypeIfNoSetType()
    {
        $outputSpeech = new OutputSpeech();
        $outputSpeech->setOutput("bla bla bla")
                     ->getFormatedData();
    }
}
