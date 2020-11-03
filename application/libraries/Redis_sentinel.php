<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter Redis
 *
 * A CodeIgniter library to interact with Redis
 *
 * @package        	CodeIgniter
 * @category    	Libraries
 * @author        	Joël Cox
 * @version			v0.4
 * @link 			https://github.com/joelcox/codeigniter-redis
 * @link			http://joelcox.nl
 * @license			http://www.opensource.org/licenses/mit-license.html
 */
class Redis_sentinel {

    /**
     * CI
     *
     * CodeIgniter instance
     * @var 	object
     */
    private $_ci;

    /**
     * Connection
     *
     * Socket handle to the Redis server
     * @var		handle
     */
    private $client;

    /**
     * Debug
     *
     * Whether we're in debug mode
     * @var		boo
     */
    public $debug = FALSE;

    /**
     * CRLF
     *
     * User to delimiter arguments in the Redis unified request protocol
     * @var		string
     */
    const CRLF = "\r\n";

    /**
     * Constructor
     */
    public function __construct($params = array())
    {

        $REDIS_CONNECT = getenv('REDIS_CONNECT');
        $REDIS_CONNECT_ARR = explode(',', $REDIS_CONNECT);
        $ItemArr = [];
        foreach ($REDIS_CONNECT_ARR as $key => $value) {
            $ItemArr[] = $value;
        }
        $sentinelConnections = $ItemArr;
        shuffle($sentinelConnections);
        $sentinel = new \Predis\Connection\Aggregate\SentinelBackedReplication($sentinelConnections,'mymaster');
        $this->client = new \Predis\Client($sentinel);
    }

    public function delRedis($keyArr = []) {
        $this->client->del($keyArr);
    }

    public function addRedis($key, $value) {
        $this->client->set($key, $value);
    }

    public function setHS($key, $field, $value) {
        $this->client->hset($key, $field, $value);
    }

    public function getHS($key, $field) {
        return $this->client->hget($key, $field);
    }

    public function delHS($key, $field) {
        return $this->client->hdel($key, $field);
    }

    public function sendChannel($channel, $messageArr) {
        foreach ($messageArr as $key => $value) {
            $this->client->publish($channel, $value);
        }
    }

    public function getAllKey() {
        return $this->client->keys('*');
    }

}