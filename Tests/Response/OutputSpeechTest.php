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
        $this->assertTrue($outputSpeech->setOutput("Simple text to return"));

        $this->assertEquals([
            "type" => "PlainText",
            "text" => "Simple text to return"
        ], $outputSpeech->getFormatedData());
    }

    public function testSSMLOutput()
    {
        $outputSpeech = new OutputSpeech();
        $outputSpeech->setType(OutputSpeech::TYPE_SSML);
        $this->assertTrue($outputSpeech->setOutput("Text SSML format."));

        $this->assertEquals([
            "type" => "SSML",
            "ssml" => "Text SSML format."
        ], $outputSpeech->getFormatedData());
    }

    public function testWrongDataToOutput()
    {
        $outputSpeech = new OutputSpeech();
        $outputSpeech->setType(OutputSpeech::TYPE_SSML);
        $this->assertFalse($outputSpeech->setOutput([
            'no matter'
        ]));

        $this->assertFalse($outputSpeech->getFormatedData());
    }

    public function testWrongOutputType()
    {
        $outputSpeech = new OutputSpeech();
        $outputSpeech->setType("bla bla bla");
        $this->assertTrue($outputSpeech->setOutput("my output"));

        $this->assertFalse($outputSpeech->getFormatedData());
    }
}
