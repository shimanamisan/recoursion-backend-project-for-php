<?php

// pcntl_fork()を使用してプロセスを複製します。
$pid = pcntl_fork();

// $pidが0より大きい場合、これは親プロセスです。
if ($pid > 0) {
    // 現在のプロセス(ここでは親プロセス)のPIDを取得します。
    echo "Fork above 0, PID: " . posix_getpid() . "\n";

    // 生成された子プロセスのPIDを表示します。
    echo "Spawned child's PID: " . $pid . "\n";
}
// $pidが0の場合、これは子プロセスです。
elseif ($pid == 0) {
    // 現在のプロセス(ここでは子プロセス)のPIDを取得します。
    echo "Fork is 0, this is a Child PID: " . posix_getpid() . "\n";

    // 現在のプロセスの親プロセスのPIDを取得します。
    echo "Parent PID: " . posix_getppid() . "\n";
}
