<?php
use \PhpGrpc\Proto\Common\SecurityIdentifier;
use \PhpGrpc\Grpc\Marketdata\SubscribeQuotesRequest;
use \PhpGrpc\Grpc\Marketdata\SubscribeQuotesResponse;
use \PhpGrpc\Grpc\Marketdata\SubscribeQuotesResponse_Response;
use \PhpGrpc\Grpc\Marketdata\TaggedSecurity;

require_once('vendor/autoload.php');

$client = new \PhpGrpc\Grpc\Marketdata\MDStreamClient('msa-ftcd1-tst02:5666', [
    'Authorization' => 'fb17882585bbfe9c55733a6e46a265ddaea6957a',
    'credentials' => null,
]);

$message = new SubscribeQuotesRequest();
$message->setSecurities([(new TaggedSecurity())->setId((new SecurityIdentifier())->setSecurityId($_SERVER['argv'][1]))]);

$call = $client->SubscribeQuotes();
$call->write($message);

/** @var $result SubscribeQuotesResponse */
$result = $call->read();

foreach ($result->getQuotes()->getIterator() as $val) {
    /** @var $val SubscribeQuotesResponse_Response */
    if ($val->getQuote() && $val->getQuote()->getValue()) {
        echo "Low: " . getValue($val->getQuote()->getLow()) . "\n";
        echo "Last: " . getValue($val->getQuote()->getLast()) . "\n";
        echo "High: " . getValue($val->getQuote()->getHigh()) . "\n";
        echo "\n";
    }
}

function getValue(\PhpGrpc\Proto\Common\DecimalValue $val)
{
    return $val->getNum() + $val->getFrac() * pow(10, -$val->getScale());
}
