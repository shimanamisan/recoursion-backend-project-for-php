FROM php:8.2.8-fpm

RUN apt-get update && \
  apt-get -y install git libicu-dev libonig-dev libzip-dev unzip locales \ 
  procps iputils-ping net-tools git lsof strace && \
  # aptのパッケージリストを削除（イメージのサイズを小さくするため）
  apt-get clean && \
  # aptのパッケージリストを削除（イメージのサイズを小さくするため）
  rm -rf /var/lib/apt/lists/* && \
  # ロケールを生成
  locale-gen ja_JP.UTF-8 && \
  # ロケールを定義
  localedef -f UTF-8 -i ja_JP ja_JP.UTF-8 && \
  # PHP-FPMのランタイムデータを格納するディレクトリを作成
  mkdir /var/run/php-fpm && \
  # PHPログを格納するためのディレクトリを作成
  mkdir /var/log/php && \
  # pcntlをインストール
  docker-php-ext-install intl pdo_mysql mbstring zip bcmath pcntl sockets && \
  pecl install xdebug && \
  # Xdebug を有効化する
  docker-php-ext-enable xdebug && \
  # 名前付きパイプの出力先 /data/temp/ ディレクトリを作成する
  mkdir -p /data/temp/

COPY ./php-fpm.d/zzz-www.conf /usr/local/etc/php-fpm.d/zzz-www.conf
COPY ./php.ini /usr/local/etc/php/php.ini

# Composer Install
# 公式の Composer イメージを利用
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# rootユーザー実行した際に警告が出ないようにする
ENV COMPOSER_ALLOW_SUPERUSER 1
# Composerのホームディレクトリを変更
ENV COMPOSER_HOME /composer
# コマンドが実行できるようにパスを通す
ENV PATH $PATH:/composer/vendor/bin

# 作業ディレクトリの設定
WORKDIR /workspace

# ユーザーの追加
RUN useradd -m -s /bin/bash user01 && \
    # Xebugで使用するログファイルの作成とファイルへのアクセス権限を付与する
    touch /var/log/xdebug.log && \
    chown user01:user01 /var/log/xdebug.log && \
    chmod 644 /var/log/xdebug.log && \
    # /data/temp/ ディレクトリのアクセス権限の変更
    chown -R user01:user01 /data/temp/ && \
    chmod -R 700 /data/temp/