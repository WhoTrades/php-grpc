<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 *
 * @package PhpGrpc
 */
namespace PhpGrpc;

use Grpc\Txsecurities\SecuritiesSearchRequest;
use Grpc\Txsecurities\TXSecuritiesClientClient;

class TXSecurities
{
    // ag: Error Codes - https://developers.google.com/maps-booking/reference/grpc-api-v2/status_codes

    /**
     * @var TXSecuritiesClientClient
     */
    protected $clientTXSecurities;

    /**
     * @param string $hostname // host:port
     */
    public function __construct($hostname)
    {
        $this->clientTXSecurities = new TXSecuritiesClientClient($hostname, ['credentials' => null]);
    }

    public function search($query, $lang)
    {
        $message = new SecuritiesSearchRequest();
        $message->setLimit(10);
        $message->setQuery($query);
        //$message->setLang($lang);

        /** @var /Grpc/UnaryCall $call */
        $call = $this->clientTXSecurities->Search($message, [], ['credentials' => null]);
        $call->wait();
var_dump($call);
        echo json_encode($this->clientTXSecurities->Search($message, [], ['credentials' => null])->wait());
    }
}
