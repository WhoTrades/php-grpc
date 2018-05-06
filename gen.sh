#!/bin/bash


set +e

# an: Dirty hack. Idea taken from https://github.com/grpc/grpc/blob/v1.10.x/src/php/bin/generate_proto_php.sh
sed -i 's/message Empty /message EmptyMessage /g' ./vendor/google/protobuf/src/google/protobuf/empty.proto

find protos -name '*.proto' -exec sed -i 's/(google.protobuf.Empty)/(google.protobuf.EmptyMessage)/g' {} \;

find protos -name '*.proto' -exec sed -i 's/\.protos/\.proto/g' {} \;

protoc --proto_path=protos/finam/txsecurities/src/ \
       --proto_path=protos/finam/transaq/src/ \
       --proto_path=protos/finam/cgate/src/ \
       --proto_path=protos/finam/proto/src/ \
       --proto_path=vendor/google/protobuf/src/ \
       --php_out=auto \
       --grpc_out=auto \
       --plugin=protoc-gen-grpc=/home/vagrant/grpc/bins/opt/grpc_php_plugin \
	$@

