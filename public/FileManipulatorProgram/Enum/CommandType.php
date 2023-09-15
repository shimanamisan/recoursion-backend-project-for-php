<?php

namespace FileManipulatorProgram\Enum;

enum CommandType: string {
    case REVERSE = "reverse";
    case COPY = "copy";
    case DUPLICATE = "duplicate-contents";
    case REPLACE = "replace-string";
}