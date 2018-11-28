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

    /**
     * @param string | null $query
     * @param int | null $lang // @see \Proto\Common\Lang::*
     * @param int | null $limit
     *
     * @return \Grpc\Txsecurities\ClientSecurity[]
     */
    public function search($query = null, $lang = null, $limit = null)
    {
        $message = new SecuritiesSearchRequest();
        if ($query) {
            $message->setQuery($query);
        }
        if ($lang) {
            $message->setLang($lang);
        }
        if ($limit) {
            $message->setLimit($limit);
        }

        /** @var \Grpc\UnaryCall $call */
        $call = $this->clientTXSecurities->Search($message, [], ['credentials' => null]);
        /** @var \Grpc\Txsecurities\SecuritiesSearchResponse $reply */
        list($reply, $status) = $call->wait();
        /** @var \Google\Protobuf\Internal\RepeatedField $issueList */
        $issueList = $reply->getIssues();
        /** @var \Google\Protobuf\Internal\RepeatedFieldIter $issueListIterator */
        $issueListIterator = $issueList->getIterator();

        $result = [];
        /** @var \Grpc\Txsecurities\ClientSecurity $issue */
        foreach ($issueListIterator as $issue) {
            $result[] = $issue;
        }

        return $result;
    }
}
