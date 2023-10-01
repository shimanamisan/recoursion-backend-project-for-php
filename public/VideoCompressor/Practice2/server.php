<?php

// ユーザーからの入力を受け取り、それを別のプログラムに送信する役割を果たすサーバ
// 標準入力（stdin）からのユーザーの入力を受け取り、名前付きパイプに直接書き込み、
// それを別のプロセス（この場合はクライアント）に送信する

// json_decode: JSON文字列を解析する
$config = json_decode(file_get_contents('config.json'), true);

// ファイルが存在するか確認し、unlink関数で削除する
if (file_exists($config['filepath'])) {
    // 既に同じ名前のパイプが存在する場合はそれを削除する
    // これは新しいセッションをクリーンな状態から開始するため
    unlink($config['filepath']);
}

// 指定したパスに名前付きパイプを作成する
// 名前付きパイプは一方向のデータフローを持つ特殊なファイルの一種
// パーミッションを0600に設定し、所有者が読み書き可能であることを示す
posix_mkfifo($config['filepath'], 0600);

echo "FIFO named '{$config['filepath']}' is created successfully.\n";
echo "Type in what you would like to send to clients.\n";

// ユーザーからの入力を取得し、それを名前付きパイプに書き込む
// 'exit'が入力されるまでこの操作を繰り返す
$flag = true;

while ($flag) {
    // ユーザーからの入力を取得し、$inputStr変数に代入する
    $inputStr = fgets(STDIN);

    // rtrim関数で入力から末尾の空白や改行を削除する
    $inputStr = rtrim($inputStr);

    if ($inputStr === 'exit') {
        $flag = false;
    } else {
        // ファイルを書き込みモードで開く
        // file_put_contents関数でデータを名前付きパイプに書き込む
        // この関数は、fopen()、fwrite()、 fclose() を続けてコールしてデータをファイルに書き込むのと等価
        file_put_contents($config['filepath'], $inputStr);
    }
}

// プログラムの終了時に名前付きパイプを削除する
unlink($config['filepath']);
