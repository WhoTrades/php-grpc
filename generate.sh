#!/bin/bash

find ../../finam/ -name '*.proto'|xargs -I {} bash generate_proto.sh {};
bash generate_proto.sh ../../google/protobuf/src/google/protobuf/empty.proto;
