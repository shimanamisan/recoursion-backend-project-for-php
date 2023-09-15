# FileManipulatorProgram

# 概要

コマンドの引数を受け取ってファイル操作を行うプログラムです。

以下のコマンドを受け取り、スクリプトファイルは各処理を実行します。
```bash
$ php index.php [コマンド] [入力ファイル] [出力ファイル or 反復回数 or 置換後の文字列]
```

# Reverse

入力ファイル内の文字列を反転させてファイルに出力する
```bash
$ php index.php reverse input.txt output.txt
```

![reverse-command](https://github.com/shimanamisan/recoursion-backend-project-for-php/assets/49751604/cf7d34ab-4c83-4c19-9a0c-a9f401adcaf3)

# Copy

入力ファイルを複製する
```bash
$ php index.php copy input.txt output.txt
```

![cooy-command](https://github.com/shimanamisan/recoursion-backend-project-for-php/assets/49751604/c888a438-026c-4610-98ae-87f215a525da)

# DuplicateContents

入力ファイルと複製回数を指定して、入力ファイル内の文字列をn回反復する
```bash
$ php index.php duplicate-contents input.txt 5
```

![duplicate-contents-command](https://github.com/shimanamisan/recoursion-backend-project-for-php/assets/49751604/624d4f2c-4ecc-4631-b565-201792fde846)

# ReplaceString

入力ファイル内の`needle`という文字列を検索し、`needle`を全て`newstring`という文字列に置き換える
```bash
$ php index.php replace-string input.txt needle newstring
```

![replace-string-command](https://github.com/shimanamisan/recoursion-backend-project-for-php/assets/49751604/337d724f-da8b-4527-a843-1e48ae57a4c4)