<?php
namespace Weysan\Alexa\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Component\HttpFoundation\Request;
use Weysan\Alexa\AlexaIncomingRequest;
use Weysan\Alexa\Response\SessionAttributes;

class AlexaIncomingRequestTest extends TestCase
{

    public function testIncomingParsing()
    {
        $body = file_get_contents(__DIR__ . '/incoming.json');
        $psr7Factory = new DiactorosFactory();
        $request = Request::create('/', 'POST', array(), array(), array(), array(), $body);
        $psr_request = $psr7Factory->createRequest($request);
        $parser = new AlexaIncomingRequest($psr_request);

        $this->assertNotEmpty($parser->getAppId());
        $this->assertEquals("GetJoke", $parser->getRequestIntent());
        $this->assertEquals("1.0", $parser->getVersion());
        $this->assertEquals("IntentRequest", $parser->getRequestType());
        $this->assertEquals("fakeuserID-hjfd-55674654", $parser->getUserId());
        $this->assertEquals("SessionId.hjkjhj-6546546-lfhdsjh", $parser->getSessionId());
    }

    public function testIncomingParsingWithSessionAttributes()
    {
        $body = json_encode([
            'session' => [
                'attributes' => [
                    'key1' => 'value1',
                    'key2' => 'value2',
                    'key3' => 'value3',
                ]
            ]
        ]);
        $psr7Factory = new DiactorosFactory();
        $request = Request::create('/', 'POST', array(), array(), array(), array(), $body);
        $psr_request = $psr7Factory->createRequest($request);
        $parser = new AlexaIncomingRequest($psr_request);

        $this->assertTrue($parser->getSessionAttributes() instanceof SessionAttributes);
        $this->assertEquals('value1', $parser->getSessionAttributes()->getAttribute('key1'));
        $this->assertEquals('value2', $parser->getSessionAttributes()->getAttribute('key2'));
        $this->assertEquals('value3', $parser->getSessionAttributes()->getAttribute('key3'));
    }

    public function testIncomingSlotValue()
    {
        $body = file_get_contents(__DIR__ . '/incoming_with_slot.json');
        $psr7Factory = new DiactorosFactory();
        $request = Request::create('/', 'POST', array(), array(), array(), array(), $body);
        $psr_request = $psr7Factory->createRequest($request);
        $parser = new AlexaIncomingRequest($psr_request);

        $this->assertEquals('toto', $parser->getIntentSlotValue("Jokename"));
        $this->assertEquals('1986-04-07', $parser->getIntentSlotValue("Date"));
        $this->assertFalse($parser->getIntentSlotValue("Whatever"));
    }
}
