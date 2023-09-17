<?php

require __DIR__ . '/../vendor/autoload.php';

use FileManipulatorProgram\Factories\CommandFactory;

// $argvにはコマンドラインからの引数が格納される
if ($argc < 4) { // $argcはコマンドラインからの引数の数
    echo "使用法: php index.php [コマンド] [入力ファイル] [出力ファイル or 反復回数 or 置換後の文字列]\n";
    exit(1);
}

$handle = CommandFactory::create(command: $argv[1], inputFile: $argv[2], secondArg: $argv[3]);

try {

    $handle->execute();

    echo "正常に終了しました\n";

    exit(0);

} catch(\Exception $e) {

    echo $e->getMessage();

} finally {

    $handle->fileClose();
}
