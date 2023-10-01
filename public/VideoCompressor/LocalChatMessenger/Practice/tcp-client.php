<?php

// ソケットの作成
// INFO: https://www.php.net/manual/ja/function.socket-create.php
$sock = socket_create(AF_UNIX, SOCK_STREAM, 0);

// サーバが待ち受けている場所にソケットを接続する
$server_address = "/workspace/tcp_socket_file";

echo "サーバーアドレス " . $server_address . "に接続します。\n";

// サーバに接続する
// 何か問題があった場合、エラーメッセージを表示してプログラムを終了する
// INFO: https://www.php.net/manual/ja/function.socket-connect.php
$result = socket_connect($sock, $server_address);
if (!$result) {
    // INFO: https://www.php.net/manual/ja/function.socket-strerror.php
    // INFO: https://www.php.net/manual/ja/function.socket-last-error.php
    echo socket_strerror(socket_last_error()) . "\n";
    exit(1);
}

// サーバに接続できたら、サーバにメッセージを送信する
// ソケット通信ではデータをバイト形式で送る必要がある
$message = "Sending a message to the server side";

// INFO: https://www.php.net/manual/ja/function.socket-write.php
socket_write($sock, $message, strlen($message));

// サーバからの応答を待ち、応答があればそれを表示する
// INFO: https://www.php.net/manual/ja/function.socket-set-option.php
socket_set_option($sock, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 2, "usec" => 0));

// INFO: https://www.php.net/manual/ja/function.socket-read.php
while ($out = socket_read($sock, 2048)) {
    echo "Server Response: " . $out . "\n";
}

// サーバからの応答がなければ、エラーメッセージを表示する
if (socket_last_error($sock) == SOCKET_ETIMEDOUT) {
    echo "タイムアウトしました。 サーバーメッセージ受信を終了します。\n";
}

// すべての操作が完了したら、ソケットを閉じます。
echo "ソケットを閉じます。\n";

// INFO: https://www.php.net/manual/ja/function.socket-close.php
socket_close($sock);
