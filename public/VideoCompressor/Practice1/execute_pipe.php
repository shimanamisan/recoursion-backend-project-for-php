<?php

// パイプを作成します
$pipe = stream_socket_pair(STREAM_PF_UNIX, STREAM_SOCK_STREAM, STREAM_IPPROTO_IP);

if ($pipe === false) {
    die('Unable to create a socket pair.');
}

// プロセスをフォークします
$pid = pcntl_fork();

if ($pid == -1) {
    // フォークに失敗した場合、エラーメッセージを出力します
    die('Could not fork.');
} elseif ($pid) {
    // 親プロセス
    // パイプの読み取り端を閉じます
    fclose($pipe[0]);

    // メッセージを生成します
    $message = "Message from parent with pid " . getmypid();

    // メッセージを出力します
    echo "Parent, sending out the message - $message\n";

    // メッセージをパイプに書き込みます
    fwrite($pipe[1], $message);

    // パイプの書き込み端を閉じます
    fclose($pipe[1]);
} else {
    // 子プロセス
    // パイプの書き込み端を閉じます
    fclose($pipe[1]);

    // 子プロセスのIDを出力します
    echo "Fork is 0, this is a Child PID: " . getmypid() . "\n";

    // パイプからメッセージを読み取ります
    $incoming = fread($pipe[0], 1024);

    // 受信したメッセージを出力します
    echo "Incoming string: $incoming\n";

    // パイプの読み取り端を閉じます
    fclose($pipe[0]);
}
