<?php
require __DIR__ . '/vendor/autoload.php';

use App\TwitterAPI;

/**
 * Start streaming from Twitter.
 */
// parse XML
$xml = simplexml_load_file(__DIR__ . '/API_Key.xml');
$xmlObj = get_object_vars($xml);
$twitter = $xmlObj['twitter'];

// The OAuth credentials you received when registering your app at Twitter
define("TWITTER_CONSUMER_KEY", $twitter->consumer_key);
define("TWITTER_CONSUMER_SECRET", $twitter->consumer_secret);
// The OAuth data for the twitter account
define("OAUTH_TOKEN", $twitter->oauth_token);
define("OAUTH_SECRET", $twitter->oauth_secret);

/* Start streaming */
$sc = new TwitterAPI(OAUTH_TOKEN, OAUTH_SECRET, Phirehose::METHOD_FILTER);

/* Keywords */
$sc->setTrack(['テレビ', '会社', 'それ', 'the']);
//$sc->setTrack(['災害', '防災', '地震', '豪雨', '津波', '台風', '火山', '自治体', 'ハザード']);
//$sc->setTrack(['Disaster', 'Prevention Disaster', 'Earthquake', 'Heavy Rain', 'Flood', 'Typhoon', 'Volcanic', 'Local Government', 'Hazard']);

/* Language */
$sc->setLang('ja');

/* Stream start. */
$sc->consume();
