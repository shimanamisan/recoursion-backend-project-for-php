<?php

namespace VideoCompressor\LocalChatMessenger\Messenger;

use Socket;
use Faker\Factory;
use VideoCompressor\LocalChatMessenger\Interface\IFileOperation;

class UdpServer implements IFileOperation
{
    private const SERVER_ADDRESS = __DIR__ . '/udp_socket_file';

    // INFO: https://www.php.net/manual/ja/class.socket.php
    private Socket $socket;

    // INFO: https://www.php.net/manual/ja/language.types.mixed.php
    private array $fakers;

    public function __construct()
    {
        $this->createSocket();
        $this->fakerData();
    }

    public function execute(): void
    {
        try {

            socket_bind($this->socket, self::SERVER_ADDRESS);

            while(true) {

                echo "waiting to receive message\n";

                // ソケットからのデータを受信する
                // 4096は一度に受信できる最大バイト数
                $buf = "";
                // UDPクライアントのアドレスが格納される
                $from = "";

                // INFO: https://www.php.net/manual/ja/function.socket-recvfrom.php
                socket_recvfrom($this->socket, $buf, 4096, 0, $from);

                // 受信したデータのバイト数と送信元のアドレスを表示する
                echo "received: " . strlen($buf) . " bytes from {$from}\n";

                // 受信したデータが有ればFakerで作成したデータを送り返す
                switch($buf) {
                    case (int)$buf === 1:
                        $this->sendMessageExecute("name: " . $this->fakers['name'], $from);
                        break;
                    case (int)$buf === 2:
                        $this->sendMessageExecute("email: " . $this->fakers['email'], $from);
                        break;
                    case (int)$buf === 3:
                        $this->sendMessageExecute("text: " . $this->fakers['text'], $from);
                        break;
                    default:
                        echo "不正な受信データです。";

                }

            }

        } catch(\Exception $e) {

            throw $e;

        } finally {

            $this->deleteSocket();

        }
    }

    private function sendMessageExecute($message, $from): void
    {

        if(empty($from)) {
            throw new \Exception("不正なUDPクライアントのアドレスです。");
        }

        $sent = socket_sendto($this->socket, $message, strlen($message), 0, $from);

        if(!$sent) {
            echo "socket_sendto() failed: reason: " . socket_strerror(socket_last_error($this->socket)) . "\n";
        }

        echo "sent {$sent} bytes back to {$from}\n";
    }

    private function fakerData(): void
    {
        // INFO: https://fakerphp.github.io/#localization
        $faker = Factory::create('ja_JP');

        $this->fakers = [
            // 日本語の名前を生成する
            // male を指定すると男性の名前が生成される
            // female を指定すると女性の名前が生成される
            // 引数に何も指定しないとランダムに名前が生成される
            "name" => $faker->kanaName(),
            "email" => $faker->email(),
            "text" => $faker->text(100)
        ];
    }

    public function createSocket(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

        // 既にソケットファイルが存在している場合は削除する
        $this->deleteSocket();

        echo 'starting up on server: '. self::SERVER_ADDRESS . "\n";
    }

    public function deleteSocket(): void
    {
        if (file_exists(self::SERVER_ADDRESS)) {
            unlink(self::SERVER_ADDRESS);
        }

        echo 'delete: '. self::SERVER_ADDRESS . "\n";
    }
}
