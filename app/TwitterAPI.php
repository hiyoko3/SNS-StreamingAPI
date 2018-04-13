<?php
namespace App;

require __DIR__ . '/../vendor/autoload.php';

use OauthPhirehose;
use Phirehose;
use WebSocket\Client;
use WebSocket\BadOpcodeException;

/**
 * A wrapper for PHP to use the Twitter Streaming API. [https://github.com/fennb/phirehose]
 * Class TwitterAPI
 * @package App
 */
class TwitterAPI extends OauthPhirehose{
    private $client;
    public function __construct($username, $password, $method = Phirehose::METHOD_SAMPLE, $format = self::FORMAT_JSON, $lang = FALSE){
        parent::__construct($username, $password, $method, $format, $lang);

        /* A wrapper of web socket client for PHP [https://github.com/Textalk/websocket-php] */
        $this->client = new Client("ws://localhost:8001");
    }

    public function enqueueStatus($status) {
        $data = json_decode($status, true);

        if (is_array($data) && isset($data['user']['screen_name'])) {
            print $data['user']['screen_name'] . ': ' . urldecode($data['text']) . "\n";

            // Build a text.
            $text = preg_replace('/[\xF0-\xF7][\x80-\xBF][\x80-\xBF][\x80-\xBF]/', '', urldecode($data['text']));
            if(is_array($data['coordinates']) && isset($data['coordinates'])){
                $latitude  = $data['geo']['coordinates'][0];
                $longitude = $data['geo']['coordinates'][1];
            }

            // Send to web socket.
            try {
                $this->client->send($text);
            }catch (BadOpcodeException $e){
                echo "An error has occurred: {$e->getMessage()}\n";;
            }
        }
    }
}