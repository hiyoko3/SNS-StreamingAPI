<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\WebSocket;

require __DIR__ . '/vendor/autoload.php';

/**
 * Start web socket server.
 */
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new WebSocket() // Build an app.
        )
    ),
    8001 // port number
);

$server->run(); // start
