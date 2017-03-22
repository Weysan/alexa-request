<?php
namespace Weysan\Alexa\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Weysan\Alexa\AlexaIncomingRequest;
use Weysan\Alexa\AlexaOutgoingGenerator;
use Weysan\Alexa\IntentRegistry;
use Weysan\Alexa\Intents\IntentsInterface;
use Weysan\Alexa\Response\OutputSpeech;
use Weysan\Alexa\Response\SessionAttributes;
use Weysan\Alexa\Tests\Mock\MockIntentWithAlexaIncomingClass;

class AlexaOutgoingGeneratorTest extends TestCase
{

    public function setUp()
    {
        IntentRegistry::registerIntentHandler("GetJoke", $this->getIntentClassMock());
        IntentRegistry::registerIntentHandler("GetJokeSSML", $this->getIntentClassMockSSML());
    }

    public function tearDown()
    {
        IntentRegistry::unregisterIntentHandler("GetJoke");
        IntentRegistry::unregisterIntentHandler("GetJokeSSML");
    }


    public function testGenerationOutgoing()
    {
        $output = new AlexaOutgoingGenerator($this->getAlexaIncomingInstance());

        $this->assertEquals([
            "version" => "0.1",
            "response" => [
                "outputSpeech" => [
                    "type" => "PlainText",
                    "text" => "fake"
                ],
                "shouldEndSession" => true
            ],
            "sessionAttributes" => []
        ], $output->getResponse());
    }

    public function testGenerationOutgoingWithoutEndingSession()
    {
        $output = new AlexaOutgoingGenerator($this->getAlexaIncomingInstance());
        $output->willEndSession(false);
        $this->assertEquals([
            "version" => "0.1",
            "response" => [
                "outputSpeech" => [
                    "type" => "PlainText",
                    "text" => "fake"
                ],
                "shouldEndSession" => false
            ],
            "sessionAttributes" => []
        ], $output->getResponse());

        $output->willEndSession(true);

        $this->assertEquals([
            "version" => "0.1",
            "response" => [
                "outputSpeech" => [
                    "type" => "PlainText",
                    "text" => "fake"
                ],
                "shouldEndSession" => true
            ],
            "sessionAttributes" => []
        ], $output->getResponse());
    }

    public function testGenerationOutgoingWithSSMLMessage()
    {
        $output = new AlexaOutgoingGenerator($this->getAlexaIncomingInstance('incoming_ssml.json'));
        $output->willEndSession(false);
        $this->assertEquals([
            "version" => "0.1",
            "response" => [
                "outputSpeech" => [
                    "type" => "SSML",
                    "ssml" => "fake ssml message"
                ],
                "shouldEndSession" => false
            ],
            "sessionAttributes" => []
        ], $output->getResponse());
    }


    /**
     * Test the DI of incoming message
     */
    public function testInjectIncomingRequestToIntentHandler()
    {
        $intentMock = new MockIntentWithAlexaIncomingClass();
        $incomingMock = $this->getAlexaIncomingInstance();

        IntentRegistry::registerIntentHandler("GetJoke", $intentMock);

        new AlexaOutgoingGenerator($incomingMock);

        $this->assertEquals($incomingMock, $intentMock->getAlexaIncomingRequest());
    }

    /**
     * @param string $file_incoming
     * @return AlexaIncomingRequest
     */
    protected function getAlexaIncomingInstance($file_incoming = 'incoming.json')
    {
        $body = file_get_contents(__DIR__ . '/' . $file_incoming);
        $request = new Request(array(), array(), array(), array(), array(), array(), $body);
        $parser = new AlexaIncomingRequest($request);
        return $parser;
    }

    protected function getIntentClassMock($intentMock = null)
    {
        $fakeOutput = new OutputSpeech();
        $fakeOutput->setType(OutputSpeech::TYPE_PLAIN_TEXT);
        $fakeOutput->setOutput("fake");

        if (null === $intentMock) {
            $intentMock = \Mockery::mock(IntentsInterface::class)->makePartial();
        }

        $intentMock->shouldReceive("getResponseObject")->once()->andReturn(
            $fakeOutput
        );
        $intentMock->shouldReceive("getSessionAttributes")->once()->andReturn(
            new SessionAttributes()
        );
        return $intentMock;
    }

    protected function getIntentClassMockSSML($intentMock = null)
    {
        $fakeOutput = new OutputSpeech();
        $fakeOutput->setType(OutputSpeech::TYPE_SSML);
        $fakeOutput->setOutput("fake ssml message");

        if (null === $intentMock) {
            $intentMock = \Mockery::mock(IntentsInterface::class)->makePartial();
        }

        $intentMock->shouldReceive("getResponseObject")->once()->andReturn(
            $fakeOutput
        );
        $intentMock->shouldReceive("getSessionAttributes")->once()->andReturn(
            new SessionAttributes()
        );
        return $intentMock;
    }
}
