<?php
namespace App;

require __DIR__ . '/../vendor/autoload.php';

use Spatie\TwitterStreamingApi\PublicStream;

$xml = simplexml_load_file(__DIR__ . '/../API_Key.xml');
$xmlObj = get_object_vars($xml);
var_dump($xmlObj['twitter']);

//PublicStream::create(
//    $twitter['oauth_token'],
//    $twitter['oauth_secret'],
//    $twitter['consumer_key'],
//    $twitter['cunsumer_secret']
//)->whenHears('@spatie_be', function(array $tweet) {
//    echo "We got mentioned by {$tweet['user']['screen_name']} who tweeted {$tweet['text']}";
//})->checkFilterPredicates(function($stream) {
//    $trackIds = ExternalStorage::get('TwitterTrackIds');
//    if ($trackIds != $stream->getTrack()) {
//        $stream->setTrack($trackIds);
//    }
//})->startListening();

//// Filter
//class TwitterStreamingAPI extends OauthPhirehose{
//
//    public function enqueueStatus($status)
//    {
//        $data = json_decode($status, true);
//        $latitude = '';
//        $longitude = '';
//        $text = '';
//
//        if (is_array($data) && isset($data['user']['screen_name'])) {
//            $tweet = new Tweet();
//            $text = preg_replace('/[\xF0-\xF7][\x80-\xBF][\x80-\xBF][\x80-\xBF]/', '', urldecode($data['text']));
//            if(is_array($data['coordinates']) && isset($data['coordinates'])){
//                $latitude  = $data['geo']['coordinates'][0];
//                $longitude = $data['geo']['coordinates'][1];
//            }
//
//            $tweet->fill([
//                'username'          => $data['user']['screen_name'],
//                'tweet'             => $text,
//                'image_path'        => $data['user']['profile_image_url'],
//                'favorite_count'    => $data['favorite_count'],
//                'retweet_count'     => $data['retweet_count'],
//                'latitude'          => $latitude,
//                'longitude'         => $longitude,
//                'tweeted_at'        => $data['created_at']
//            ]);
//
//            if(!$tweet->save()){
//                print 'error\n';
//            }
//        }
//    }
//}
//
//// Start streaming
//$sc = new TwitterStreamingAPI(OAUTH_TOKEN, OAUTH_SECRET, Phirehose::METHOD_FILTER);
//// $sc->setTrack(['テレビ', '会社', 'hello', 'the']);
////$sc->setTrack(['災害', '防災', '地震', '豪雨', '津波', '台風', '火山', '自治体', 'ハザード']);
//$sc->setTrack(['Disaster', 'Prevention Disaster', 'Earthquake', 'Heavy Rain', 'Flood', 'Typhoon', 'Volcanic', 'Local Government', 'Hazard']);
//$sc->setLang('en');
//$sc->consume();
