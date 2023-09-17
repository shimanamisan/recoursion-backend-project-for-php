<?php

require __DIR__ . '/../vendor/autoload.php';

use MarkdownToHTMLConverter\Converter;

// $argvにはコマンドラインからの引数が格納される
if ($argc < 4) {
    echo "使用法: php index.php [コマンド] [入力ファイル] [出力ファイル]\n";
    exit(1);
}

try {

    $handle = new Converter(command: $argv[1], inputFile: $argv[2], outputFile: $argv[3]);

    $handle->execute();

} catch(\Exception $e) {

    echo $e->getMessage();

} finally {

    $handle->fileClose();

}
