<?php
namespace App\Config;

use Illuminate\Database\Capsule\Manager as Capsule;
use Exception;

abstract class SingletonCore{
    //コンストラクタはprotected
    protected function __construct(){}

    final public static function getInstance()
    {
        static $instance;
        return $instance ?: $instance = new static;
    }

    final public function __clone() {
        throw new Exception("this instance is singleton class.");
    }
}

/**
 * データベース接続処理
 */
class DBManager extends SingletonCore{
    // file path.
    private $yml = __DIR__ . '/../database.yml';

    // Environment
    private $env = 'development'; // production, development, test

    // Database Config Object
    private $config;

    private $capsule;

    protected function __construct(){
        $parsed = yaml_parse($this->yml);
        $this->config = $parsed['database'][$this->env];

        $this->capsule = new Capsule;
    }

    public function init() {
        try {
            $this->capsule->addConnection([
                'driver' => 'mysql',
                'host' => '127.0.0.1',
                'database' => $this->config['host'],
                'username' => $this->config['username'],
                'password' => $this->config['password'],
                'port' => $this->config['port'],
                'collation' => 'utf8_unicode_ci',
                'charset' => $this->config['charset'],
            ]);
            $this->capsule->setAsGlobal();
            $this->capsule->bootEloquent();
        } catch (Exception $e) {
            exit('データベース接続失敗。' . $e->getMessage());
        }
    }
}
