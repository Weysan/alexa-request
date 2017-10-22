<?php

/*
 * That file should be the entry point from alexa
 * it will handle the incoming request from Alexa and generate
 * the output to Alexa.
 */

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/MyCustomIntent.php';

use Weysan\Alexa\AlexaIncomingRequest;
use Weysan\Alexa\AlexaOutgoingGenerator;

\Weysan\Alexa\IntentRegistry::registerIntentHandler("MyCustomIntent", new MyCustomIntent());

$alexaIncoming = new AlexaIncomingRequest($request);
$alexaOutgoing = new AlexaOutgoingGenerator($alexaIncoming);
print json_encode($alexaOutgoing->getResponse());