<?php

namespace MarkdownToHTMLConverter;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;

class Converter
{
    /** ファイルハンドル @var resource */
    private $handle;

    private string $inputFile;

    private string $outputFile;

    public function __construct(string $command, string $inputFile, string $outputFile)
    {
        if($command !== "markdown") {
            throw new \Exception("コマンドはmarkdownを指定して下さい\n");
        }

        $this->inputFile = $inputFile;
        $this->outputFile = $outputFile;
    }

    public function execute()
    {
        try {

            if (!$this->checkFileExistsAndReadable()) {
                throw new \Exception("入力ファイルが存在しないか、読み取り可能ではありません\n");
            }

            // 読み込み専用で開く
            $this->handle = fopen($this->inputFile, "r");

            if(!$this->handle) {
                throw new \Exception("ファイルの読み取りに失敗しました\n");
            }

            $readContents = fread($this->handle, filesize($this->inputFile));

            $config = [
                'html_input' => 'escape',
                'allow_unsafe_links' => false,
                'table' => [
                    'wrap' => [
                        'enabled' => false,
                        'tag' => 'div',
                        'attributes' => [],
                    ],
                ],
            ];

            $environment = new Environment($config);
            $environment->addExtension(new CommonMarkCoreExtension());
            $environment->addExtension(new TableExtension());
            $converter = new CommonMarkConverter();

            // htmlに変換
            $convertContents = $converter->convert($readContents);


            // 書き込み専用で開く
            $outputHandle = fopen($this->outputFile, "w");
            fwrite($outputHandle, $convertContents);
            fclose($outputHandle);

        } catch(\Exception $e) {

            throw $e;

        } finally {
            $this->fileClose();
        }
    }

    /**
    * ファイルを閉じる
    */
    public function fileClose(): void
    {
        if(is_resource($this->handle)) {
            fclose($this->handle);
        }
    }

    /**
    * ファイルが存在して読み取り可能かどうかを確認する
    *
    * @return bool ファイルが存在して読み取り可能な場合はtrue、それ以外はfalse
    */
    public function checkFileExistsAndReadable(): bool
    {
        if(file_exists($this->inputFile) && is_readable($this->inputFile)) {
            return true;
        }

        return false;
    }
}
