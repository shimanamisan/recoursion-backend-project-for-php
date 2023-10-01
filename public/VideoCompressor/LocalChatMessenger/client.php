<?php

require __DIR__ . '/../../vendor/autoload.php';

use VideoCompressor\LocalChatMessenger\Messenger\UdpClient;

$client = new UdpClient();

try {

    $client->execute();

} catch(\Exception $e) {

    echo $e->getMessage();

    exit(1);
}
