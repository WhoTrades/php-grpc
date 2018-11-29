<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 *
 * @package PhpGrpc
 */
namespace PhpGrpc;

use \Proto\Common\SecurityIdentifier;
use \Grpc\Marketdata\SubscribeQuotesRequest;
use \Grpc\Marketdata\SubscribeQuotesResponse;
use \Grpc\Marketdata\TaggedSecurity;
use \Grpc\Marketdata\MDStreamClient;

class MDStream
{
    // ag: Error Codes - https://developers.google.com/maps-booking/reference/grpc-api-v2/status_codes

    /**
     * @var MDStreamClient
     */
    protected $clientMDStream;

    /**
     * @param string $hostname // host:port
     */
    public function __construct($hostname)
    {
        $this->clientMDStream = new MDStreamClient($hostname, ['credentials' => null]);
    }

    /**
     * @param int $finamId
     *
     * @return \Proto\Marketdata\Quote[]
     */
    public function getQuotesByFinamId($finamId)
    {
        $result = [];

        $message = new SubscribeQuotesRequest();
        $message->setSecurities([(new TaggedSecurity())->setId((new SecurityIdentifier())->setSecurityId($finamId))]);

        /** @var /Grpc/BidiStreamingCall $call */
        $call = $this->clientMDStream->SubscribeQuotes();
        $call->write($message);

        /** @var $response SubscribeQuotesResponse */
        if ($response = $call->read()) {
            /** @var $val SubscribeQuotesResponse\Response */
            foreach ($response->getQuotes()->getIterator() as $val) {
                $result[] = $val->getQuote();
            }
        }

        return $result;
    }
}
