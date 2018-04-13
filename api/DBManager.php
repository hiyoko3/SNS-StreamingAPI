<?php
namespace App\Config;

require_once dirname(__FILE__) . '/vendor/autoload.php';

use Mapyo\EloquentOnly\Eloquent;
use Exception;

trait SingletonTrait{
    //コンストラクタはprotected
    protected function __construct(){}

    final public static function getInstance()
    {
        static $instance;
        return $instance ?: $instance = new static;
    }

    final public function __clone()
    {
        throw new Exception("this instance is singleton class.");
    }
}

/**
 * データベース接続処理
 */
class DBManager{
    use SingletonTrait;

    protected function __construct(){
    }

    public function init(){
        // 接続処理
        try {
            Eloquent::init([
                'driver'   => 'mysql',
                //'host'     => '153.126.137.149',
                'host'     => '127.0.0.1',
                'database' => 'tweets_test',
                //'database' => 'Oyanagi_TestDB',
                'username' => 'root',
                //'password' => 'C(SPtL#KJq',
                'password' => 'root',
                'port'     => 3306,
                'collation' => 'utf8_unicode_ci',
                'charset'  => 'utf8',
            ]);
        }catch (Exception $e){
            exit('データベース接続失敗。' . $e->getMessage());
        }
    }
}
