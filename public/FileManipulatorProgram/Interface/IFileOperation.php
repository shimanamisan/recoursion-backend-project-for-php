<?php

namespace FileManipulatorProgram\Interface;

interface IFileOperation
{
    public function fileClose(): void;

    public function checkFileExistsAndReadable(): bool;

    public function execute(): void;
}
