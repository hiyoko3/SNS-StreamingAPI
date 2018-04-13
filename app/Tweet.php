<?php

require_once dirname(__FILE__) . '/vendor/autoload.php';
require_once dirname(__FILE__) . '/DBManager.php';

use Illuminate\Database\Eloquent\Model;
use App\DBManager;

// Model
class Tweet extends Model
{
    public function __construct(array $attributes = array()){
        // Database への接続
        DBManager::getInstance()->init();
        
        parent::__construct($attributes);
    }

    protected $table = 'tweets';
    protected $fillable = [
        'username',
        'tweet',
        'image_path',
        'favorite_count',
        'retweet_count',
        'latitude',
        'longitude',
        'tweeted_at'
    ];

}
