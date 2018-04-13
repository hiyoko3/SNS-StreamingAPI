<?php
namespace App;

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Database\Eloquent\ModelNotFoundException;

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

/**
 * A wrapper of Server Sent Event for PHP.
 * Class ServerSentEvent
 * @package App
 */
class ServerSentEvent {
    public function __construct(){}

    public function stream() {
        // Not use
//        while (1) {
//            try{
//                echo "data: Hello World." , "\n\n"; //TODO: You must add "data: ".
//                ob_flush();
//                flush();
//                sleep(1);
//            }catch (ModelNotFoundException $e){
//                sleep(1);
//                continue;
//            }
//        }

    }
}