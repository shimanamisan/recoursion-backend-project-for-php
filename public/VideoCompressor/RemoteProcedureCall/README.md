# RemoteProcedureCall

# 概要

コマンドラインから実行する RPC システムです。

クライアントから呼び出されたメソッドの実行結果をJSON形式で返します。

ソケットを利用して、Dockerコンテナ上の異なるプログラム間で通信します。

ネットワークイメージ図
![network](https://github.com/shimanamisan/recoursion-backend-project-for-php/assets/49751604/e87aafbd-927d-408d-b916-f4ea4f33b156)

クライアント側のプログラムは以下のリポジトリを参照して下さい。

[recoursion-backend-project-for-client](https://github.com/shimanamisan/recoursion-backend-project-for-client)

# 実行可能なメソッド

## floor(double x)

引数`x`の小数点以下を切り捨てた値を返します。

```json
// $x = 1.23456

// レスポンスの例
{   
    results: 1,
    result_type: 'double',
    id: 1
}
```

## nroot(int n, int x)

ある数 x の n 乗根を計算し、対数の底を求めます（r^n = x の r の値 ）

```json
// $n = 3
// $x = 8

// レスポンスの例
{
    results: 2,
    result_type: 'integer',
    id: 2
}
```

{ results: 2, result_type: 'integer', id: 2 }

## reverse(string s)

反転した文字列を返します。

```json
// $s = 'あいうえお'

// レスポンスの例
{
    results: 'おえういあ',
    result_type: 'string',
    id: 3
}
```

## validAnagram(string str1, string str2)

`str1`と`str2`がアナグラムの関係になっているかを、真か偽で返します。

```json
// $str1 = 'Astronomer'
// $str2 = 'moon starer'

// レスポンスの例
{
    results: true,
    result_type: 'boolean',
    id: 4
}
```

## sort(string[] strArr)

文字列の配列`strArr`をソートした配列を返します。

```json
// $nstrArr = ["あ","い","う","え","お"]

{
    results: [ 'お', 'え', 'う', 'い', 'あ' ],
    result_type: 'array',
    id: 5
}
```

# 使用方法

クライアントと共有するdockerネットワークを追加します。

```bash
$ docker network create external-api --subnet=192.168.1.0/24 --gateway=192.168.1.1
```

以下のコマンドを実行して、クライアントからの通信を待機します。

```bash
$ cd /public/VideoCompressor/RemoteProcedureCall

$ php index.php
starting up on server. 
waiting for a connection from a client: 192.168.1.3
```

