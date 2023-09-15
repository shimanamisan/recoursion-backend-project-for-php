<?php

namespace FileManipulatorProgram\Library;

use FileManipulatorProgram\Interface\IFileOperation;

/**
 * ファイルをコピーするクラス
 */
class Copy implements IFileOperation
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
     * ファイルをコピーして出力する
     *
     * @throws \Exception ファイルが存在しないか読み取りに失敗した場合に例外を投げる
     */
    public function execute(): void
    {
        try {

            if (!$this->checkFileExistsAndReadable()) {
                throw new \Exception("入力ファイルが存在しないか、読み取り可能ではありません\n");
            }

            copy($this->inputFile, $this->outputFile);

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
