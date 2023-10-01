<?php

// UNIXドメインソケットとデータグラム（非接続）ソケットを作成する
$sock = socket_create(AF_UNIX, SOCK_DGRAM, 0);

// サーバのアドレスを定義する
// サーバはこのアドレスでメッセージを待ち受ける
$server_address = '/workspace/udp_socket_file';

// このクライアントのアドレスを定義する
// サーバはこのアドレスにメッセージを返す
$client_address = '/workspace/udp_client_socket_file';

// もし前回の実行でソケットファイルが残っていた場合、そのファイルを削除する
if (file_exists($client_address)) {
    unlink($client_address);
}

// サーバに送信するメッセージを定義する
$message = 'サーバにメッセージを送信します。';

// このクライアントのアドレスをソケットに紐付ける
// これはUNIXドメインソケットの場合に限る
// このアドレスはサーバによって送信元アドレスとして受け取られる
socket_bind($sock, $client_address);

try {
    // サーバにメッセージを送信する
    echo "sending: {$message}\n";

    // INFO: https://www.php.net/manual/ja/function.socket-sendto.php
    $sent = socket_sendto($sock, $message, strlen($message), 0, $server_address);

    // サーバからの応答を待ち受ける
    echo "waiting to receive\n";
    // 最大4096バイトのデータを受け取る
    $buf = '';
    $from = '';

    // INFO: https://www.php.net/manual/ja/function.socket-recvfrom.php
    socket_recvfrom($sock, $buf, 4096, 0, $from);

    // サーバから受け取ったメッセージを表示する
    echo "received: {$buf}\n";

} finally {
    // 最後にソケットを閉じてリソースを解放する
    echo "closing socket\n";
    socket_close($sock);
}
