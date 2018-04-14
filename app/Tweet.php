<?php
namespace App;

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Database\Eloquent\Model;

/**
 * A Model for tweet data.
 * Class Tweet
 * @package App
 */
class Tweet extends Model {
    public function __construct(array $attributes = array()){
        // Database への接続
        DBManager::getInstance()->init();

        parent::__construct($attributes);
    }
    protected $table = 'tweets';
    protected $fillable = [
        'username',
        'text',
        'image_path',
        'favorite_count',
        'retweet_count',
        'latitude',
        'longitude',
        'tweeted_at'
    ];
}