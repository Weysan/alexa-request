<?php
namespace Weysan\Alexa\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Weysan\Alexa\AlexaIncomingRequest;
use Weysan\Alexa\AlexaOutgoingGenerator;
use Weysan\Alexa\IntentRegistry;
use Weysan\Alexa\Intents\IntentsInterface;
use Weysan\Alexa\Response\OutputSpeech;

class AlexaOutgoingGeneratorTest extends TestCase
{
    public function testGenerationOutgoing()
    {
        IntentRegistry::registerIntentHandler("GetJoke", $this->getIntentClassMock());

        $output = new AlexaOutgoingGenerator($this->getAlexaIncomingInstance());

        $this->assertEquals([
            "version" => "0.1",
            "response" => [
                "outputSpeech" => [
                    "type" => "PlainText",
                    "text" => "fake"
                ]
            ],
            "sessionAttributes" => [],
            "shouldEndSession" => true
        ], $output->getResponse());
    }

    /**
     * @return AlexaIncomingRequest
     */
    protected function getAlexaIncomingInstance()
    {
        $body = file_get_contents(__DIR__ . '/incoming.json');
        $request = new Request(array(), array(), array(), array(), array(), array(), $body);
        $parser = new AlexaIncomingRequest($request);
        return $parser;
    }

    protected function getIntentClassMock()
    {
        $fakeOutput = new OutputSpeech();
        $fakeOutput->setType(OutputSpeech::TYPE_PLAIN_TEXT);
        $fakeOutput->setOutput("fake");

        $intentMock = \Mockery::mock(IntentsInterface::class);
        $intentMock->shouldReceive("getResponseObject")->once()->andReturn(
            $fakeOutput
        );
        return $intentMock;
    }
}
