<?php
require_once dirname(__FILE__) . '/phirehose/lib/Phirehose.php';
require_once dirname(__FILE__) . '/phirehose/lib/OauthPhirehose.php';
require_once dirname(__FILE__) .  '/Tweet.php';

date_default_timezone_set('Asia/Tokyo');

define("TWITTER_CONSUMER_KEY", "kJAqraq1j97un8z3SJ0E9Aq9O");
define("TWITTER_CONSUMER_SECRET", "WlDIgQ0l3fMGtNG3WZWzp7i0RSORXwC1KCt9VfLyfDTRVTVjoR");
define("OAUTH_TOKEN", "1286057664-ArAWtUVd0hOyGnx39rpbyvoN9cd7QAUBQj2yQbU");
define("OAUTH_SECRET", "tBQIWEfAhE4TBRd5jR1LS2QLyY9RbsLWACEb33uL4YJan");

// Filter
class TwitterStreamingAPI extends OauthPhirehose{

    public function enqueueStatus($status)
    {
        $data = json_decode($status, true);
        $latitude = '';
        $longitude = '';
        $text = '';

        if (is_array($data) && isset($data['user']['screen_name'])) {
            $tweet = new Tweet();
            $text = preg_replace('/[\xF0-\xF7][\x80-\xBF][\x80-\xBF][\x80-\xBF]/', '', urldecode($data['text']));
            if(is_array($data['coordinates']) && isset($data['coordinates'])){
                $latitude  = $data['geo']['coordinates'][0];
                $longitude = $data['geo']['coordinates'][1];
            }

            $tweet->fill([
                'username'          => $data['user']['screen_name'],
                'tweet'             => $text,
                'image_path'        => $data['user']['profile_image_url'],
                'favorite_count'    => $data['favorite_count'],
                'retweet_count'     => $data['retweet_count'],
                'latitude'          => $latitude,
                'longitude'         => $longitude,
                'tweeted_at'        => $data['created_at']
            ]);

            if(!$tweet->save()){
                print 'error\n';
            }
        }
    }
}

// Start streaming
$sc = new TwitterStreamingAPI(OAUTH_TOKEN, OAUTH_SECRET, Phirehose::METHOD_FILTER);
// $sc->setTrack(['テレビ', '会社', 'hello', 'the']);
//$sc->setTrack(['災害', '防災', '地震', '豪雨', '津波', '台風', '火山', '自治体', 'ハザード']);
$sc->setTrack(['Disaster', 'Prevention Disaster', 'Earthquake', 'Heavy Rain', 'Flood', 'Typhoon', 'Volcanic', 'Local Government', 'Hazard']);
$sc->setLang('en');
$sc->consume();
