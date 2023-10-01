# LocalChatMessenger

# 概要

UDPソケットを使用してテキストメッセージのやり取りを行うプログラムです。

ダミーデータを生成するライブラリは[lfakerphp/faker](https://fakerphp.github.io/)を使用しています。

# 使い方

ターミナルを2つ開きます。

![スクリーンショット 2023-10-01 135058](https://github.com/shimanamisan/recoursion-backend-project-for-php/assets/49751604/c8ed033a-b8e8-4069-b944-e48df3c0e7a4)

2つのターミナルで以下のコマンドを実行します。

```bash
$ cd public/VideoCompressor/LocalChatMessenger
```

メッセージを受けるサーバ側のプログラムを実行します。

![php-local-chat-messenger](https://github.com/shimanamisan/recoursion-backend-project-for-php/assets/49751604/3b9c5064-c7c4-453f-bc30-f8a41feef0a5)

```bash
$ php server.php
```

メッセージを送信するクライアント側のプログラムを実行し、受け取りたいメッセージを選択します。

```bash
$ php client.php
```

Fakerから生成された名前を受信する例です。

![php-local-chat-messenger-client1](https://github.com/shimanamisan/recoursion-backend-project-for-php/assets/49751604/fd36437f-71bd-4cf2-abb6-2cef630bf8f1)

メールアドレスを受信する例です。

![php-local-chat-messenger-client2](https://github.com/shimanamisan/recoursion-backend-project-for-php/assets/49751604/5d7276ac-0ae6-453c-9d17-63db24248f14)

テキストメッセージを取得する例です。

![php-local-chat-messenger-client3](https://github.com/shimanamisan/recoursion-backend-project-for-php/assets/49751604/e2234f46-18b0-4980-b73e-6c5ab270482c)

メッセージ受信後、クライアント側のプログラムは自動で終了しますが、サーバ側のプログラムは次の受信を待機します。

終了する場合は`Ctrl + c`で終了して下さい。

その際に、Messengerディレクトリ配下に作成されたソケットファイルは手動で削除する必要があります。

![スクリーンショット 2023-10-01 140042](https://github.com/shimanamisan/recoursion-backend-project-for-php/assets/49751604/c4c544b8-001a-4c8e-9ab2-0bf24ca08b19)

```bash
$ rm Messenger/udp_socket_file
```