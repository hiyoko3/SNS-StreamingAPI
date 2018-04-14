<?php
namespace App;

require __DIR__ . '/../vendor/autoload.php';

use OauthPhirehose;
use Phirehose;
use WebSocket\Client;
use WebSocket\BadOpcodeException;
use App\Tweet;

/**
 * A wrapper for PHP to use the Twitter Streaming API. [https://github.com/fennb/phirehose]
 * Class TwitterAPI
 * @package App
 */
class TwitterAPI extends OauthPhirehose{
    private $client;
    private $tweet;
    // Tweet info.
    private $user = '';
    private $text = '';
    private $imagePath = '';
    private $favoriteCount = 0;
    private $retweetCount = 0;
    private $latitude = null;
    private $longitude = null;
    private $tweetedAt = '';

    public function __construct($username, $password, $method = Phirehose::METHOD_SAMPLE, $format = self::FORMAT_JSON, $lang = FALSE){
        parent::__construct($username, $password, $method, $format, $lang);

        /* A wrapper of web socket client for PHP [https://github.com/Textalk/websocket-php] */
        $this->client = new Client("ws://localhost:8001");
    }

    public function enqueueStatus($status) {
        $data = json_decode($status, true);

        if (is_array($data) && isset($data['user']['screen_name'])) {
            $this->text = preg_replace('/[\xF0-\xF7][\x80-\xBF][\x80-\xBF][\x80-\xBF]/', '', urldecode($data['text']));

            // Remove `RT`, `reply`, `Tweet with URL`
            if(!preg_match("/^@/", $this->text) && !preg_match("/^RT/", $this->text) && !preg_match("/[http, https]/", $this->text)) {
                $this->tweet = new Tweet();
                // Build a text.
                $this->user = $data['user']['screen_name'];
                $this->imagePath = $data['user']['profile_image_url'];
                if (is_array($data['coordinates']) && isset($data['coordinates'])) {
                    $this->latitude = $data['geo']['coordinates'][0];
                    $this->longitude = $data['geo']['coordinates'][1];
                }

                if (isset($data['favorite_count'])) {
                    $this->favoriteCount = $data['favorite_count'];
                }

                if (isset($data['retweet_count'])) {
                    $this->retweetCount = $data['retweet_count'];
                }

                $this->tweetedAt = $data['created_at'];

                // Save data
                if ($this->favoriteCount > 30 || $this->retweetCount > 30) {
                    $this->tweet->fill([
                        'username' => $this->user,
                        'text' => $this->text,
                        'image_path' => $this->imagePath,
                        'favorite_count' => $this->favoriteCount,
                        'retweet_count' => $this->retweetCount,
                        'latitude' => $this->latitude,
                        'longitude' => $this->longitude,
                        'tweeted_at' => $this->tweetedAt
                    ]);
                    $this->tweet->save();
                }

                // Send to web socket.
                try {
                    $message = "{$this->user},{$this->text},{$this->imagePath},{$this->favoriteCount},{$this->retweetCount},{$this->latitude},{$this->longitude},{$this->tweetedAt}";
                    $this->client->send($message);
                } catch (BadOpcodeException $e) {
                    echo "An error has occurred: {$e->getMessage()}\n";;
                }
            }
        }
    }
}