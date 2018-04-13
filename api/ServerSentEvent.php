<?php
require_once dirname(__FILE__) . '/Tweet.php';

use Illuminate\Database\Eloquent\ModelNotFoundException;

$tweets = Tweet::query()->orderBy('created_at', 'asc');
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

while (1) {
    try{
        $t = $tweets->firstOrFail();
        echo "data: $t->username, $t->tweet, $t->image_path, $t->like_count, $t->retweet_count, $t->latitude, $t->longitude, $t->tweeted_at" , "\n\n"; //TODO: 必ず "data: " をつけること！！！
        ob_flush();
        flush();
        $t->delete();
        sleep(1);
    }catch (ModelNotFoundException $e){
        sleep(1);
        continue;
    }
}
