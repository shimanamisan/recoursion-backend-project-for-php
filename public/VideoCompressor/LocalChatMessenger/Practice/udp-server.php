<?php

// socket_create関数を使用して、新しいソケットを作成する
// AF_UNIXはUNIXドメインソケットを表し、SOCK_DGRAMはデータグラムソケットを表す
$sock = socket_create(AF_UNIX, SOCK_DGRAM, 0);

// サーバが接続を待ち受けるUNIXドメインソケットのパスを指定する
$server_address = '/workspace/udp_socket_file';

// もし前回の実行でソケットファイルが残っていた場合、そのファイルを削除する
if (file_exists($server_address)) {
    unlink($server_address);
}

// ソケットが起動していることを表示する
echo "starting up on {$server_address}\n";

// socket_bind関数を使って、ソケットを特定のアドレスに関連付けする
socket_bind($sock, $server_address);

// ソケットはデータの受信を永遠に待ち続ける
while (true) {
    echo "waiting to receive message\n";

    $buf = "";
    $from = "";

    // ソケットからのデータを受信する
    // 4096は一度に受信できる最大バイト数
    // INFO: https://www.php.net/manual/ja/function.socket-recvfrom.php
    socket_recvfrom($sock, $buf, 4096, 0, $from);

    // 受信したデータのバイト数と送信元のアドレスを表示する
    echo "received: " . strlen($buf) . " bytes from {$from}\n";
    // クラアントから送られてきたメッセージに文字列を追加する
    $return = "サーバからのメッセージです: {$buf}";
    echo "このメッセージをクライアントに送信します: {$return}\n";

    // 受信したデータをそのまま送信元に送り返す
    if ($return) {
        $sent = socket_sendto($sock, $return, strlen($return), 0, $from);
        // 送信したバイト数と送信先のアドレスを表示する
        echo "sent {$sent} bytes back to {$from}\n";
    }
}
