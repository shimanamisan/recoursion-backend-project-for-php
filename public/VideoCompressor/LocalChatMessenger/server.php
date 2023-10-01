<?php

require __DIR__ . '/../../vendor/autoload.php';

use VideoCompressor\LocalChatMessenger\Messenger\UdpServer;

$server = new UdpServer();


try {

    $server->execute();

} catch(\Exception $e) {

    echo $e->getMessage();

    exit(1);
}
