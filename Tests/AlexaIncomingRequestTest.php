<?php
namespace Weysan\Alexa\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Weysan\Alexa\AlexaIncomingRequest;

class AlexaIncomingRequestTest extends TestCase
{

    public function testIncomingParsing()
    {
        $body = file_get_contents(__DIR__ . '/incoming.json');
        $request = new Request(array(), array(), array(), array(), array(), array(), $body);
        $parser = new AlexaIncomingRequest($request);

        $this->assertNotEmpty($parser->getAppId());
        $this->assertEquals("GetJoke", $parser->getRequestIntent());
    }
}