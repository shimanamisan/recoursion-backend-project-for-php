<?php

namespace VideoCompressor\RemoteProcedureCall\Socket;

use Socket;
use Datto\JsonRpc\Evaluator;

class Server
{
    /**
     * 接続を許可するIPアドレス
     */
    private const HOST_ADDRESS = '192.168.1.3';

    /**
     * ポート
     */
    private const PORT = 8000;

    private Socket $socket;

    private Socket | bool $clientApproval;

    private Evaluator $api;

    private mixed $jsonObj;

    public function __construct(Evaluator $api)
    {
        $this->startUpServer();
        $this->api = $api;
    }

    public function receiveMessage(): void
    {
        // クライアントからのメッセージを受け取る
        $message = socket_read($this->clientApproval, 1024);
        echo 'Received message: ' . $message . "\n";

        // JSON文字列をオブジェクトにデコード
        $this->jsonObj = $this->json_decode($message);

        $result = $this->api->evaluate($this->jsonObj->method, $this->jsonObj->param);

        $jsonResponse = $this->generateJsonResopnse($result);

        $this->sendResponseMessage($jsonResponse);
    }

    private function json_decode($jsonString){
        try {
            // json_decodeメソッドのエラーハンドリング（PHP 7.3以降）
            // INFO: https://qiita.com/kubotak/items/d35cfa5c3367ab837b4b
            return json_decode($jsonString, false, 512, JSON_THROW_ON_ERROR);

        } catch (\JsonException  $e) {
            throw $e;
        }
    }

    private function json_encode($jsonString){
        try {

            // json_encodeメソッドのエラーハンドリング（PHP 7.3以降）
            // INFO: https://qiita.com/kubotak/items/d35cfa5c3367ab837b4b
            return json_encode($jsonString, JSON_THROW_ON_ERROR);

        } catch (\JsonException $e) {
            throw $e;
        }
    }

    private function generateJsonResopnse($value): string
    {
        $result = [
            'results' => $value,
            'result_type' => gettype($value),
            'id' => $this->jsonObj->id
        ];

        return $this->json_encode($result);
    }

    private function sendResponseMessage(string $response): void
    {
        // クライアントへの返答
        socket_write($this->clientApproval, $response);
    }

    private function startUpServer(): void
    {
        // ソケットの生成
        $this->socket = socket_create(AF_INET, SOCK_STREAM, 0);

        if (!$this->socket) {
            throw new \Exception("Failed to create socket: " . socket_strerror(socket_last_error()) . "\n");
        }

        // ソケットのバインド
        if(!socket_bind($this->socket, self::HOST_ADDRESS, self::PORT)) {
            throw new \Exception("Failed to bind to address: " . socket_strerror(socket_last_error()) . "\n");
        }

        echo "starting up on server. \n";
        echo 'waiting for a connection from a client: '. self::HOST_ADDRESS . "\n";

        // 接続の待機
        if (!socket_listen($this->socket)) {
            throw new \Exception("Failed to listen on socket: " . socket_strerror(socket_last_error()) . "\n");
        }

        // 接続を受け付ける
        $this->clientApproval = socket_accept($this->socket);
    }

    public function socketDestroy(): void
    {
        // ソケットが有効かどうかを確認
        if (is_resource($this->socket)) {
            socket_close($this->socket);
        }

        if (is_resource($this->clientApproval)) {
            socket_close($this->clientApproval);
        }
    }

}
