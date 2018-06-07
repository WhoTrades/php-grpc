<?php

use Finam\Protobuf\Txsecurities\SecuritiesSearchRequest;
use Finam\Protobuf\Txsecurities\TXSecuritiesClientClient;
use Grpc\ChannelCredentials;

require_once('vendor/autoload.php');

$creds = ChannelCredentials::createInsecure();
$creds = null;

//$a = new TXSecuritiesClientClient('nya-j2tr01-tx02.corp.whotrades.eu:35558', [
//    'Authorization' => 'fb17882585bbfe9c55733a6e46a265ddaea6957a',
//    'credentials' => $creds,
//]);
$a = new TXSecuritiesClientClient('192.168.0.10:35558', [
    'Authorization' => '111',
    'credentials' => $creds,
]);

$message = new SecuritiesSearchRequest();
$message->setLimit(10);
$message->setQuery('EURUSD');

//var_export($a->Stats(new \Google\Protobuf\EmptyMessage())->wait());
var_export($a->Search($message, [], ['credentials' => $creds])->wait());

