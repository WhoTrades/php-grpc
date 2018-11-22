<?php

require_once('vendor/autoload.php');

$mdStreamHost = 'msa-ftcd1-tst02:5666';

//$txSecuritiesHost = '10.200.128.148:35554';
$txSecuritiesHost = '10.200.160.149:35554';

//$test = new \PhpGrpc\Test($mdStreamHost);
//$test->test();

$txSecurities = new \PhpGrpc\TXSecurities($txSecuritiesHost);
$txSecurities->search('tsl', 'ru');
