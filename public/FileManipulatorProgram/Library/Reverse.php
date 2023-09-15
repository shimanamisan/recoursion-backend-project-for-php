<?php

namespace FileManipulatorProgram\Library;

use FileManipulatorProgram\Interface\IFileOperation;

class Reverse implements IFileOperation
{
    /** ファイルハンドル @var resource */
    private $handle;

    /** @var string 入力ファイルのパス */
    private $inputFile;

    /** @var string 出力ファイルのパス */
    private $outputFile;

    /**
    * コンストラクタ
    *
    * @param string $inputFile  入力ファイルのパス
    * @param string $outputFile 出力ファイルのパス
    */
    public function __construct($inputFile, $outputFile)
    {
        $this->inputFile = $inputFile;
        $this->outputFile = $outputFile;
    }

    /**
     * ファイルの内容を反転させて出力する
     *
     * @throws \Exception ファイルが存在しないか読み取りに失敗した場合に例外を投げる
     */
    public function execute(): void
    {
        try {

            if (!$this->checkFileExistsAndReadable()) {
                throw new \Exception("入力ファイルが存在しないか、読み取り可能ではありません\n");
            }

            $this->handle = fopen($this->inputFile, "r");

            if(!$this->handle) {
                throw new \Exception("ファイルの読み取りに失敗しました\n");
            }

            $readContents = fread($this->handle, filesize($this->inputFile));
            $reversed = strrev($readContents);

            // ファイルが存在しなかった場合は新しいファイルが作成される
            // 既に同じファイルが存在していた場合は内容が上書きされる
            $outputHandle = fopen($this->outputFile, "w");
            fwrite($outputHandle, $reversed);
            fclose($outputHandle);

        } catch(\Exception $e) {

            // 呼び出し元に例外を投げてキャッチさせる
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
