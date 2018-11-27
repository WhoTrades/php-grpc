#!/bin/bash


set +e

# an: Dirty hack. Idea taken from https://github.com/grpc/grpc/blob/v1.10.x/src/php/bin/generate_proto_php.sh
sed -i 's/message Empty /message EmptyMessage /g' ../../google/protobuf/src/google/protobuf/empty.proto

find protos -name '*.proto' -exec sed -i 's/(google.protobuf.Empty)/(google.protobuf.EmptyMessage)/g' {} \;

find protos -name '*.proto' -exec sed -i 's/\.protos/\.proto/g' {} \;

protoc --proto_path=protos/grpc-proto/src/ \
       --proto_path=protos/grpc-marketdata/src/ \
       --proto_path=protos/grpc-txsecurities/src/ \
       --proto_path=protos/grpc-transaq/src/ \
       --proto_path=../../google/protobuf/src/ \
       --php_out=generated \
       --grpc_out=generated \
       --plugin=protoc-gen-grpc=/usr/local/bin/grpc_php_plugin \
	$@

