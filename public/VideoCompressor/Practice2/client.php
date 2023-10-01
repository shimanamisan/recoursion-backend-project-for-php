<?php

// 名前付きパイプからデータを読み取るためのクライアントプログラム
// このプログラムは、ループで名前付きパイプをポーリングし、新しいメッセージが送信されるとそれを読み取る
// ポーリングとは、コンピュータのプログラムが定期的に特定の状態をチェックするプロセスのこと

// json_decode: JSON文字列を解析する
$config = json_decode(file_get_contents('config.json'), true);

// fopen関数でファイルを読み取りモードで開く
$f = fopen($config['filepath'], 'r');

// 名前付きパイプの続きを読む
// フラグは、パイプが存在する間はtrueとし、パイプが存在しなくなったらfalseにする
$flag = true;

while ($flag) {
    // 指定したパスのファイルが存在しない場合、Falseに設定してwhileループを終了する
    if (!file_exists($config['filepath'])) {
        $flag = false;
    }

    // ファイルからデータを読み込む
    // 一度にすべてのデータを読み込む
    // INFO: https://www.php.net/manual/ja/function.stream-get-contents.php
    $data = stream_get_contents($f);

    // データが空でない場合、その内容を出力する
    if (strlen($data) != 0) {
        echo "Data received from pipe: {$data}\n";
    }
}

// パイプが存在しなくなった後、ファイルを閉じてリソースを解放する
fclose($f);
