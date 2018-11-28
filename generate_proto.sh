#!/bin/bash

set +e

protoc --proto_path=../../finam/grpc-proto/src/ \
       --proto_path=../../finam/grpc-marketdata/src/ \
       --proto_path=../../finam/grpc-txsecurities/src/ \
       --proto_path=../../finam/grpc-transaq/src/ \
       --proto_path=../../google/protobuf/src/ \
       --php_out=generated \
       --grpc_out=generated \
       --plugin=protoc-gen-grpc=/usr/local/bin/grpc_php_plugin \
	$@

