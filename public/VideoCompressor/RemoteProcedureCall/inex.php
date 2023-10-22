<?php

require __DIR__ . '/../../vendor/autoload.php';

use VideoCompressor\RemoteProcedureCall\Api;
use VideoCompressor\RemoteProcedureCall\Socket\Server;

$server = new Server(new Api());

try {

    $server->receiveMessage();

} catch(\Exception $e) {

    echo $e->getMessage();

} catch(\JsonException $e){

    echo "JSON encode error: " . $e->getMessage();

} finally {
    $server->socketDestroy();
}
