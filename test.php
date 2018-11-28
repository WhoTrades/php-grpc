<?php

require_once('vendor/autoload.php');

/******************************************************************************
 * Get securities
 */
$txSecuritiesHost = '10.200.160.149:35554';

$txSecurities = new \PhpGrpc\TXSecurities($txSecuritiesHost);
$securityList = $txSecurities->search('tsl', \Proto\Common\Lang::ru, 10);

echo "\n\nGot " . count($securityList) . " securities\n\n";

/** @var \Grpc\Txsecurities\ClientSecurity $security */
foreach ($securityList as $security) {
    echo $security->serializeToJsonString();
}

/******************************************************************************
 * Get quotes
 */
$mdStreamHost = 'msa-ftcd1-tst02:5666';

//$finamId = 484958;
//$finamId = 22460;
$finamId = 393749;

$mdStream = new \PhpGrpc\MDStream($mdStreamHost);
$quoteList = $mdStream->getQuotesByFinamId($finamId);

echo "\n\nGot " . count($quoteList) . " quotes\n\n";

/** @var \Proto\Marketdata\Quote $quote */
foreach ($quoteList as $quote) {
    echo $quote->serializeToJsonString();
}
