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
    public function tearDown()
    {
        IntentRegistry::unregisterIntentHandler("GetJoke");
    }


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

    public function testGenerationOutgoingWithoutEndingSession()
    {
        IntentRegistry::registerIntentHandler("GetJoke", $this->getIntentClassMock());

        $output = new AlexaOutgoingGenerator($this->getAlexaIncomingInstance());
        $output->willEndSession(false);
        $this->assertEquals([
            "version" => "0.1",
            "response" => [
                "outputSpeech" => [
                    "type" => "PlainText",
                    "text" => "fake"
                ]
            ],
            "sessionAttributes" => [],
            "shouldEndSession" => false
        ], $output->getResponse());

        $output->willEndSession(true);

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
     * Test the DI of incoming message
     */
    public function testInjectIncomingRequestToIntentHandler()
    {
        $intentMock = \Mockery::mock(MockIntentWithAlexaIncomingClass::class);
        $incomingMock = $this->getAlexaIncomingInstance();
        $this->getIntentClassMock($intentMock);

        $intentMock->shouldReceive("setAlexaIncomingRequest")->with($incomingMock)->once();

        IntentRegistry::registerIntentHandler("GetJoke", $intentMock);

        new AlexaOutgoingGenerator($incomingMock);
        $this->assertTrue(true);
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
}
