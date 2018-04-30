#!/bin/bash


set +e

protoDir=protos

# an: Dirty hack. Idea taken from https://github.com/grpc/grpc/blob/v1.10.x/src/php/bin/generate_proto_php.sh
sed -i 's/message Empty /message EmptyMessage /g' ./vendor/google/protobuf/src/google/protobuf/empty.proto

find $protoDir -name '*.proto' -exec sed -i 's/(google.protobuf.Empty)/(google.protobuf.EmptyMessage)/g' {} \;

find $protoDir -name '*.proto' -exec sed -i 's/\.protos/\.proto/g' {} \;

protoc --proto_path=$protoDir \
       --proto_path=vendor/google/protobuf/src/ \
       --php_out=. \
       --grpc_out=. \
       --plugin=protoc-gen-grpc=/home/vagrant/grpc/bins/opt/grpc_php_plugin \
	$@

