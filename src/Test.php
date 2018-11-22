<?php
/**
 * @author Anton Gorlanov <antonxacc@gmail.com>
 *
 * @package PhpGrpc
 */
namespace PhpGrpc;

use Grpc\Txsecurities\SecuritiesSearchRequest;
use Grpc\Txsecurities\TXSecuritiesClientClient;

use \Proto\Common\SecurityIdentifier;
use \Grpc\Marketdata\SubscribeQuotesRequest;
use \Grpc\Marketdata\SubscribeQuotesResponse;
use \Grpc\Marketdata\SubscribeQuotesResponse_Response;
use \Grpc\Marketdata\TaggedSecurity;
use \Grpc\Marketdata\MDStreamClient;

class Test
{
    // ag: Error Codes - https://developers.google.com/maps-booking/reference/grpc-api-v2/status_codes

    /**
     * @var MDStreamClient
     */
    protected $clientMDStream;

    /**
     * @var TXSecuritiesClientClient
     */
    protected $clientTXSecurities;

    //protected $finamId = 484958;
//    protected $finamId = 22460;
    protected $finamId = 393749;

    /**
     * @param string $hostname // host:port
     */
    public function __construct($hostname)
    {
        $this->clientMDStream = new MDStreamClient($hostname, ['Authorization' => 'fb17882585bbfe9c55733a6e46a265ddaea6957a', 'credentials' => null]);
        $this->clientTXSecurities = new TXSecuritiesClientClient($hostname, ['Authorization' => 'fb17882585bbfe9c55733a6e46a265ddaea6957a', 'credentials' => null]);
    }

    public function test()
    {
        $message = new SecuritiesSearchRequest();
        $message->setLimit(10);
        $message->setQuery('EURUSD');

        echo json_encode($this->clientTXSecurities->Search($message, [], ['Authorization' => 'fb17882585bbfe9c55733a6e46a265ddaea6957a', 'credentials' => null])->wait());

        //var_dump($this->clientTXSecurities->AvailableExchanges(new \Google\Protobuf\EmptyMessage())->wait());
    }

    public function test3()
    {
        echo json_encode($this->clientTXSecurities->Stats(new \Google\Protobuf\EmptyMessage(), [], ['credentials' => null])->wait());
    }

    public function test2()
    {
        $message = new SubscribeQuotesRequest();
        $message->setSecurities([(new TaggedSecurity())->setId((new SecurityIdentifier())->setSecurityId($this->finamId))]);

        /** @var /Grpc/BidiStreamingCall $call */
        $call = $this->clientMDStream->SubscribeQuotes();
        $call->write($message);

        /** @var $result SubscribeQuotesResponse */
        $result = $call->read();
var_dump($result);
die;
        foreach ($result->getQuotes()->getIterator() as $val) {
            /** @var $val SubscribeQuotesResponse_Response */
            if ($val->getQuote() && $val->getQuote()->getValue()) {
                echo "Low: " . $this->getValue($val->getQuote()->getLow()) . "\n";
                echo "Last: " . $this->getValue($val->getQuote()->getLast()) . "\n";
                echo "High: " . $this->getValue($val->getQuote()->getHigh()) . "\n";
                echo "\n";
            }
        }
    }

    protected function getValue(\PhpGrpc\Proto\Common\DecimalValue $val)
    {
        return $val->getNum() + $val->getFrac() * pow(10, -$val->getScale());
    }
}
