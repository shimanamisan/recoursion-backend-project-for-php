<?php

namespace FileManipulatorProgram\Factories;

use FileManipulatorProgram\Library\Copy;
use FileManipulatorProgram\Library\Reverse;
use FileManipulatorProgram\Enum\CommandType;
use FileManipulatorProgram\Library\ReplaceString;
use FileManipulatorProgram\Interface\IFileOperation;
use FileManipulatorProgram\Library\DuplicateContents;

class CommandFactory
{
    public static function create(string $command, string $inputFile, string $secondArg): IFileOperation
    {

        if($command === CommandType::REVERSE->value) {
            return new Reverse(inputFile: $inputFile, outputFile: $secondArg);
        }

        if($command === CommandType::COPY->value) {
            return new Copy(inputFile: $inputFile, outputFile: $secondArg);
        }

        if($command === CommandType::DUPLICATE->value) {
            return new DuplicateContents(inputFile: $inputFile, replicationCount: $secondArg);
        }

        if($command === CommandType::REPLACE->value) {
            return new ReplaceString(inputFile: $inputFile, newstring: $secondArg);
        }

        throw new \InvalidArgumentException("コマンドが見つかりませんでした。");

    }
}
