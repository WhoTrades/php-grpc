#/bin/bash

set -e

#################################################################
#instal if necessary
#################################################################
#
#wget https://getcomposer.org/download/1.6.3/composer.phar
#mv composer.phar /usr/bin/composer
#chmod +x /usr/bin/composer
#
#wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
#echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php.list
#
#apt-get update
#apt-get install php7.2-cli php7.2-dev php-pear php7.2-xdebug  --yes
#curl -sL https://deb.nodesource.com/setup_9.x | bash -
#apt-get install nodejs
#
#################################################################

apt-get update
apt-get install apt-transport-https software-properties-common lsb-release ca-certificates g++ autoconf automake libtool make gcc curl git unzip libz-dev --yes

cd /tmp && git clone -b v1.16.0 https://github.com/grpc/grpc

(cd /tmp/grpc/ && git submodule update --init && make grpc_php_plugin)

(cd /tmp/grpc/third_party/protobuf/php/ext/google/protobuf && phpize && ./configure && make && sudo make install)
cp /tmp/grpc/third_party/protobuf/php/ext/google/protobuf/.libs/protobuf.so /usr/lib/php/20170718/
bash -c "echo extension=protobuf.so > /etc/php/7.2/cli/conf.d/30-protobuf.ini"

(cd /tmp/grpc/third_party/protobuf && ./autogen.sh && ./configure && make && sudo make install && ldconfig)

(cd /tmp/grpc/examples/php && composer install)

pecl install grpc
bash -c 'echo "extension=grpc.so" > /etc/php/7.2/cli/conf.d/10-grpc.ini'
