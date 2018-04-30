<?php

use Finam\Protobuf\Txsecurities\TXSecuritiesAdminClient;
use Google\Protobuf\EmptyMessage;
use Grpc\ChannelCredentials;

require_once('vendor/autoload.php');

$a = new TXSecuritiesAdminClient('nya-j2tr01-tx02.corp.whotrades.eu:35558', [
    'Authorization' => 'fb17882585bbfe9c55733a6e46a265ddaea6957a',
    'credentials' => ChannelCredentials::createDefault(),
]);

var_export($a->Stats(new EmptyMessage(), [], ['credentials' => $creds]));

