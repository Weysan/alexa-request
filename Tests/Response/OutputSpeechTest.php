<?php
namespace Weysan\Alexa\Tests\Response;

use PHPUnit\Framework\TestCase;
use Weysan\Alexa\Exceptions\UnexpectedOutputTypeException;
use Weysan\Alexa\Exceptions\WrongOutputFormatException;
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
     * @expectedException WrongOutputFormatException
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
     * @expectedException UnexpectedOutputTypeException
     */
    public function testWrongOutputType()
    {
        $outputSpeech = new OutputSpeech();
        $outputSpeech->setType("bla bla bla");
    }
}
