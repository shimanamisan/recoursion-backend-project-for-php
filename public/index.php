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


echo "What is your favorite food??\n";
$food = fgets(STDIN);
echo "Thanks for letting me know your favorite food is " . trim($food) . "\n";