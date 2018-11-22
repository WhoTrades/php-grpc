<?php

use Finam\Protobuf\Txsecurities\SecuritiesSearchRequest;
use Finam\Protobuf\Txsecurities\TXSecuritiesClientClient;
use Grpc\ChannelCredentials;

require_once('vendor/autoload.php');

$creds = ChannelCredentials::createInsecure();
$creds = null;

$a = new TXSecuritiesClientClient('192.168.0.10:35558', [
    'Authorization' => 'fb17882585bbfe9c55733a6e46a265ddaea6957a',
    'credentials' => $creds,
]);

$message = new SecuritiesSearchRequest();
$message->setLimit(10);
$message->setQuery('EURUSD');

echo json_encode($a->Search($message, [], ['credentials' => $creds])->wait());

//var_dump($a->AvailableExchanges(new \Google\Protobuf\EmptyMessage())->wait());


