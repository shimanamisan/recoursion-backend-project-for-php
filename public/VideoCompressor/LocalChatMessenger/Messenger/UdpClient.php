<?php

namespace VideoCompressor\LocalChatMessenger\Messenger;

use Socket;
use VideoCompressor\LocalChatMessenger\Interface\IFileOperation;

class UdpClient implements IFileOperation
{
    private const SERVER_ADDRESS = __DIR__ . '/udp_socket_file';

    private const CLIENT_ADDRESS = __DIR__ . '/udp_client_socket_file';

    // INFO: https://www.php.net/manual/ja/class.socket.php
    private Socket $socket;

    public function __construct()
    {
        $this->createSocket();
    }

    public function execute()
    {
        $message = $this->receiveUserInput();

        if($message === 0) {
            throw new \Exception("不正な入力値が渡ってきました。");
        }

        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

        socket_bind($this->socket, self::CLIENT_ADDRESS);

        try {

            echo "sending: {$message}\n";

            // 接続しているかどうかによらずソケットにメッセージを送信する
            $sent = socket_sendto($this->socket, $message, strlen($message), 0, self::SERVER_ADDRESS);

            echo "Sent {$sent} bytes of data from the UDP client.\n";

            // サーバからの応答を待ち受ける
            echo "waiting to receive\n";
            // 最大4096バイトのデータを受け取る
            $buf = '';
            $from = '';

            // 接続しているかどうかによらず、ソケットからデータを受信する
            socket_recvfrom($this->socket, $buf, 4096, 0, $from);

            // サーバから受け取ったメッセージを表示する
            echo "received: {$buf}\n";

        } catch(\Exception $e) {

            throw $e;

        } finally {

            $this->deleteSocket();

        }
    }

    private function isValidUserInput($input): bool
    {

        // 数値形式の文字列か判定する
        if(!is_numeric($input)) {
            echo "※ 数字を入力して下さい！ \n";
            return false;
        }

        // 数値型にキャスト
        $intInput = (int)$input;

        if ($intInput === 1 || $intInput === 2 || $intInput === 3) {
            return true;
        }

        echo "※ 1~3を入力して下さい！ \n";
        return false;
    }

    private function receiveUserInput(): int
    {
        // ユーザーからの入力を待機する
        while(true) {
            echo "サーバーから取得するメッセージを選択して下さい: \n1 ユーザーの名前:\n2 ユーザーのEmail:\n3 テキストメッセージ:\n";

            // 改行があった場合は削除する
            $input = trim(fgets(STDIN));

            if($this->isValidUserInput($input)) {
                return (int)$input;
            }
        }

        return 0;
    }

    public function createSocket(): void
    {

        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

        // 既にソケットファイルが存在している場合は削除する
        $this->deleteSocket();

        echo 'starting up on client: '. self::CLIENT_ADDRESS . "\n";

    }

    public function deleteSocket(): void
    {
        if (file_exists(self::CLIENT_ADDRESS)) {
            unlink(self::CLIENT_ADDRESS);
        }

        echo 'delete: '. self::CLIENT_ADDRESS . "\n";
    }
}
