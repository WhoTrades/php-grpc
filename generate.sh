#!/bin/bash

find protos/ -name '*.proto'|xargs -I {} bash generate_proto.sh {};
bash generate_proto.sh vendor/google/protobuf/src/google/protobuf/empty.proto;
