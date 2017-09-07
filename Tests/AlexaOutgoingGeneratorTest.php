<?php
namespace Weysan\Alexa\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Component\HttpFoundation\Request;
use Weysan\Alexa\AlexaIncomingRequest;
use Weysan\Alexa\AlexaOutgoingGenerator;
use Weysan\Alexa\IntentRegistry;
use Weysan\Alexa\Intents\IntentsInterface;
use Weysan\Alexa\Response\Cards\LinkAccountCard;
use Weysan\Alexa\Response\OutputSpeech;
use Weysan\Alexa\Response\Response;
use Weysan\Alexa\Response\SessionAttributes;
use Weysan\Alexa\Tests\Mock\MockIntentWithAlexaIncomingClass;

class AlexaOutgoingGeneratorTest extends TestCase
{

    public function setUp()
    {
        IntentRegistry::registerIntentHandler("GetJoke", $this->getIntentClassMock());
        IntentRegistry::registerIntentHandler("GetJokeSSML", $this->getIntentClassMockSSML());
        IntentRegistry::registerIntentHandler("GetJokeSessionOff", $this->getIntentClassMockSessionEndFalse());
    }

    public function tearDown()
    {
        IntentRegistry::unregisterIntentHandler("GetJoke");
        IntentRegistry::unregisterIntentHandler("GetJokeSSML");
        IntentRegistry::unregisterIntentHandler("GetJokeSessionOff");
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
        $output = new AlexaOutgoingGenerator($this->getAlexaIncomingInstance('incoming_session_off.json'));
        $this->assertEquals([
            "version" => "0.1",
            "response" => [
                "outputSpeech" => [
                    "type" => "PlainText",
                    "text" => "fake"
                ],
                "card" => [
                    'type' => 'LinkAccount'
                ],
                "shouldEndSession" => false,
                'reprompt' => [
                    "outputSpeech" => [
                        "type" => "PlainText",
                        "text" => "fake"
                    ]
                ]
            ],
            "sessionAttributes" => []
        ], $output->getResponse());

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

    public function testGenerationOutgoingWithSSMLMessage()
    {
        $output = new AlexaOutgoingGenerator($this->getAlexaIncomingInstance('incoming_ssml.json'));
        $this->assertEquals([
            "version" => "0.1",
            "response" => [
                "outputSpeech" => [
                    "type" => "SSML",
                    "ssml" => "fake ssml message"
                ],
                "shouldEndSession" => true
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
        $psr7Factory = new DiactorosFactory();
        $request = Request::create('/', 'POST', array(), array(), array(), array(), $body);
        $psr_request = $psr7Factory->createRequest($request);
        $parser = new AlexaIncomingRequest($psr_request);
        return $parser;
    }

    protected function getIntentClassMock($intentMock = null)
    {
        $fakeResponse = new Response();
        $fakeResponse->addOutput()->setType(OutputSpeech::TYPE_PLAIN_TEXT)->setOutput("fake");

        if (null === $intentMock) {
            $intentMock = \Mockery::mock(IntentsInterface::class)->makePartial();
        }

        $intentMock->shouldReceive("getResponseObject")->once()->andReturn(
            $fakeResponse
        );
        $intentMock->shouldReceive("getSessionAttributes")->once()->andReturn(
            new SessionAttributes()
        );
        return $intentMock;
    }

    protected function getIntentClassMockSessionEndFalse($intentMock = null)
    {
        $fakeResponse = new Response();
        $fakeResponse->willEndSession(false);
        $fakeResponse->addOutput()->setType(OutputSpeech::TYPE_PLAIN_TEXT)->setOutput("fake");
        $fakeResponse->addReprompt()->setType(OutputSpeech::TYPE_PLAIN_TEXT)->setOutput("fake");
        $fakeResponse->addCard(LinkAccountCard::TYPE);

        if (null === $intentMock) {
            $intentMock = \Mockery::mock(IntentsInterface::class)->makePartial();
        }

        $intentMock->shouldReceive("getResponseObject")->once()->andReturn(
            $fakeResponse
        );
        $intentMock->shouldReceive("getSessionAttributes")->once()->andReturn(
            new SessionAttributes()
        );
        return $intentMock;
    }

    protected function getIntentClassMockSSML($intentMock = null)
    {
        $fakeResponse = new Response();
        $fakeResponse->addOutput()->setType(OutputSpeech::TYPE_SSML)->setOutput("fake ssml message");

        if (null === $intentMock) {
            $intentMock = \Mockery::mock(IntentsInterface::class)->makePartial();
        }

        $intentMock->shouldReceive("getResponseObject")->once()->andReturn(
            $fakeResponse
        );
        $intentMock->shouldReceive("getSessionAttributes")->once()->andReturn(
            new SessionAttributes()
        );
        return $intentMock;
    }
}
