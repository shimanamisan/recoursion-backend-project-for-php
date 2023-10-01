<?php

// ソケットの作成
// INFO: https://www.php.net/manual/ja/function.socket-create.php
$sock = socket_create(AF_UNIX, SOCK_STREAM, 0);

// ソケットファイルのパス
// 実行権限がある workspace 配下に作成するようにする
$server_address = '/workspace/tcp_socket_file';

// サーバアドレスが存在する場合、それを削除する
if (file_exists($server_address)) {
    unlink($server_address);
}

echo "起動します: {$server_address} \n";

// ソケットにアドレスをバインド
// INFO: https://www.php.net/manual/ja/function.socket-bind.php
socket_bind($sock, $server_address);

// ソケットでのリスニングを開始
// INFO: https://www.php.net/manual/ja/function.socket-listen.php
socket_listen($sock);

while (true) {
    // クライアントからの接続を受け入れる
    // INFO: https://www.php.net/manual/ja/function.socket-accept.php
    $connection = socket_accept($sock);

    if ($connection === false) {
        // INFO: https://www.php.net/manual/ja/function.socket-strerror.php
        // INFO: https://www.php.net/manual/ja/function.socket-last-error.php
        echo "socket_accept() の実行が失敗しました。 reason: " . socket_strerror(socket_last_error($sock)) . "\n";
        break;
    } else {
        echo "クライアントから接続されました。\n";
        while (true) {
            // クライアントからのデータの受信
            // INFO: https://www.php.net/manual/ja/function.socket-read.php
            $data = socket_read($connection, 16);

            if ($data === false) {
                echo "socket_read() の実行が失敗しました。 reason: " . socket_strerror(socket_last_error($connection)) . "\n";
                break;
            }

            if ($data !== "") {
                echo "メッセージを受信しました: {$data}\n";
                $response = "Processing " . $data;

                // メッセージをクライアントに送り返す
                // INFO: https://www.php.net/manual/ja/function.socket-write.php
                socket_write($connection, $response, strlen($response));
            } else {
                echo "クライアントからのデータがありません。\n";
                break;
            }
        }
        // 接続のクローズ
        // INFO: https://www.php.net/manual/ja/function.socket-close.php
        socket_close($connection);
        echo "ソケットを閉じます。\n";
    }
}
