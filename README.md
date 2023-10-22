# recoursion-backend-project-for-php

[![PHP](https://img.shields.io/badge/PHP-8.2.8-red.svg)](https://www.php.net/downloads.php)
[![Docker](https://img.shields.io/badge/Docker-24.0.5-red.svg)](https://docs.docker.com/engine/release-notes/24.0/)
[![License](https://img.shields.io/badge/License-MIIT-blue.svg)](https://licenses.opensource.jp/MIT/MIT.html)

# 概要

Recoursionバックエンドプロジェクト（PHP）

## 前提

別途開発用のマシンを用意していることを前提としています。

WSL2環境下やDocker Desktop環境下でも動作すると思いますが、別途設定が必要になる場合があります。

Docker と VS Code の拡張機能 [Remote Development](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.vscode-remote-extensionpack) を使用することを前提としています。

## 検証済み環境

- Ubuntu 22.04.3 LTS

# 使用方法

1. 適当な作業ディレクトリで、以下のコマンドを実行します。
    ```bash
    $ git clone git@github.com:shimanamisan/recoursion-backend-project-for-php.git
    ```

2. `recoursion-backend-project-for-php`を VS Code で開き、`F1`キーでコマンドパレット開き、開発コンテナを起動します。
![スクリーンショット 2023-07-30 093122](https://github.com/shimanamisan/php-test-object/assets/49751604/8f2b59ca-8205-494d-9b47-dc385b03ccb0)

3. VS Code のターミナルを開き、起動したコンテナにアタッチされていることを確認します。
![スクリーンショット 2023-07-30 095036](https://github.com/shimanamisan/php-test-object/assets/49751604/401d5ef6-5fa0-4e2a-baf2-698f300c5124)

4. 開いたターミナルから`public`ディレクトリに移動し必要なパッケージをインストールします。
```bash
$ cd public

$ composer install
```

5. 該当のプロジェクトへ移動しコマンドを実行します。
```bash
$ cd GuessTheNumberGame
# or FileManipulatorProgram
# or MarkdownToHTMLConverter
# or VideoCompressor/LocalChatMessenger
# or VideoCompressor/RemoteProcedureCall

$ php index.php
```

# 追加作業

プロジェクト`RemoteProcedureCall`を実行する場合はクライアントと共有するdockerネットワークを追加する作業が必要になります。

```bash
$ docker network create external-api --subnet=192.168.1.0/24 --gateway=192.168.1.1
```

ネットワークイメージ図
![network](https://github.com/shimanamisan/recoursion-backend-project-for-php/assets/49751604/e87aafbd-927d-408d-b916-f4ea4f33b156)

クライアント側のリポジトリを同じサーバの任意の場所にクローンして下さい。

```bash
$ gite clone git@github.com:shimanamisan/recoursion-backend-project-for-client.git
```

サーバ側と同様にRemote Developmentでコンテナを起動し、作成したネットワークに2つのコンテナが割り当てられていることを確認します。
```bash
$ docker network inspect recoursion-backend-project-external-api
```
![スクリーンショット 2023-10-14 054319](https://github.com/shimanamisan/recoursion-backend-project-for-client/assets/49751604/2e5deed8-9e61-45c1-a7ca-2c45b842f41e)

RemoteProcedureCallディレクトリへ移動しサーバ側のプログラムを実行します。

```bash
$ cd public/VideoCompressor/RemoteProcedureCall

$ php index.php
```


# プロジェクト

- [GuessTheNumberGame](https://github.com/shimanamisan/recoursion-backend-project-for-php/tree/main/public/GuessTheNumberGame)
- [FileManipulatorProgram](https://github.com/shimanamisan/recoursion-backend-project-for-php/tree/main/public/FileManipulatorProgram)
- [MarkdownToHTMLConverter](https://github.com/shimanamisan/recoursion-backend-project-for-php/tree/main/public/MarkdownToHTMLConverter)
- [LocalChatMessenger](https://github.com/shimanamisan/recoursion-backend-project-for-php/tree/main/public/VideoCompressor/LocalChatMessenger)
- [RemoteProcedureCall](https://github.com/shimanamisan/recoursion-backend-project-for-php/tree/main/public/VideoCompressor/RemoteProcedureCall)