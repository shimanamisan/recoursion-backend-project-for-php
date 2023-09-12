<?php

printf("Hello, %s\n", "world");

// stdoutに対するファイルポインタを取得
$stdout = fopen('php://stdout', 'w');

// ファイルポインタに対して書き込む（これが内部のstdoutバッファに書き込まれる）
fwrite($stdout, "Hello, World!\n");

// stdoutバッファをフラッシュ（即座に出力）
fflush($stdout);

// ファイルポインタを閉じる
fclose($stdout);


echo "あなたの好きな食べ物はなんですか？（入力して下さい）\n";
$food = fgets(STDIN);
echo "好きな食べ物が「" . trim($food) . "」だと教えてくれてありがとうございます。\n";
