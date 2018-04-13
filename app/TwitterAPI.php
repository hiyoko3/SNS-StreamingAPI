<?php
namespace App;

require __DIR__ . '/../vendor/autoload.php';

use OauthPhirehose;
use Phirehose;

// parse XML
$xml = simplexml_load_file(__DIR__ . '/../API_Key.xml');
$xmlObj = get_object_vars($xml);
$twitter = $xmlObj['twitter'];

echo "{$twitter->consumer_key}, {$twitter->consumer_secret}, {$twitter->oauth_token}, {$twitter->oauth_secret}";
// The OAuth credentials you received when registering your app at Twitter
define("TWITTER_CONSUMER_KEY", $twitter->consumer_key);
define("TWITTER_CONSUMER_SECRET", $twitter->consumer_secret);
// The OAuth data for the twitter account
define("OAUTH_TOKEN", $twitter->oauth_token);
define("OAUTH_SECRET", $twitter->oauth_secret);

// Filter
class TwitterStreamingAPI extends OauthPhirehose{
    public function enqueueStatus($status)
    {
        $data = json_decode($status, true);
        $latitude = '';
        $longitude = '';
        $text = '';

        if (is_array($data) && isset($data['user']['screen_name'])) {
            print $data['user']['screen_name'] . ': ' . urldecode($data['text']) . "\n";
        }
    }
}

// Start streaming
$sc = new TwitterStreamingAPI(OAUTH_TOKEN, OAUTH_SECRET, Phirehose::METHOD_FILTER);
$sc->setTrack(['テレビ', '会社', 'それ', 'the']);
 $sc->setLang('ja');
 $sc->consume();
