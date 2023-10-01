<?php

namespace VideoCompressor\LocalChatMessenger\Interface;

interface IFileOperation
{
    public function createSocket(): void;

    public function deleteSocket(): void;
}
