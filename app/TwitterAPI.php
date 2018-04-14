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
    // Tweet info.
    private $user = '';
    private $text = '';
    private $imagePath = '';
    private $favoriteCount = 0;
    private $retweetCount = 0;
    private $latitude = '';
    private $longitude = '';
    private $tweetedAt = '';

    public function __construct($username, $password, $method = Phirehose::METHOD_SAMPLE, $format = self::FORMAT_JSON, $lang = FALSE){
        parent::__construct($username, $password, $method, $format, $lang);

        /* A wrapper of web socket client for PHP [https://github.com/Textalk/websocket-php] */
        $this->client = new Client("ws://localhost:8001");
    }

    public function enqueueStatus($status) {
        $data = json_decode($status, true);

        if (is_array($data) && isset($data['user']['screen_name'])) {
            // Build a text.
            $this->user = $data['user']['screen_name'];
            $this->text = preg_replace('/[\xF0-\xF7][\x80-\xBF][\x80-\xBF][\x80-\xBF]/', '', urldecode($data['text']));
            $this->imagePath = $data['user']['profile_image_url'];
            if(is_array($data['coordinates']) && isset($data['coordinates'])){
                $this->latitude  = $data['geo']['coordinates'][0];
                $this->longitude = $data['geo']['coordinates'][1];
            }
            $this->favoriteCount = $data['favorite_count'];
            $this->retweetCount = $data['retweet_count'];
            $this->tweetedAt = $data['created_at'];

            $message = "{$this->user},{$this->text},{$this->imagePath},{$this->favoriteCount},{$this->retweetCount},{$this->latitude},{$this->longitude},{$this->tweetedAt}";

            // Send to web socket.
            try {
                $this->client->send($message);
            }catch (BadOpcodeException $e){
                echo "An error has occurred: {$e->getMessage()}\n";;
            }
        }
    }
}