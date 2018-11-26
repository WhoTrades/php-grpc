<?php

require_once('vendor/autoload.php');

$mdStreamHost = 'msa-ftcd1-tst02:5666';


//$test = new \PhpGrpc\Test($mdStreamHost);
//$test->test();

//$txSecuritiesHost = '10.200.128.148:35554';
$txSecuritiesHost = '10.200.160.149:35554';

$txSecurities = new \PhpGrpc\TXSecurities($txSecuritiesHost);
$securityList = $txSecurities->search('tsl', \Proto\Common\Lang::ru, 10);

var_dump(count($securityList));

/** @var \Grpc\Txsecurities\ClientSecurity $issue */
foreach ($securityList as $issue) {
    var_dump($issue->serializeToJsonString());
}
