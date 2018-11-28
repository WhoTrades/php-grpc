#!/bin/bash

# an: Dirty hack. Idea is taken from https://github.com/grpc/grpc/blob/v1.10.x/src/php/bin/generate_proto_php.sh
sed -i 's/message Empty /message EmptyMessage /g' ../../google/protobuf/src/google/protobuf/empty.proto
find ../../finam -name '*.proto' -exec sed -i 's/(google.protobuf.Empty)/(google.protobuf.EmptyMessage)/g' {} \;
#find ../../finam -name '*.proto' -exec sed -i 's/\.protos/\.proto/g' {} \;

find ../../finam/ -name '*.proto'|xargs -I {} bash generate_proto.sh {};
bash generate_proto.sh ../../google/protobuf/src/google/protobuf/empty.proto;

# change it back
sed -i 's/message EmptyMessage /message Empty /g' ../../google/protobuf/src/google/protobuf/empty.proto
find ../../finam -name '*.proto' -exec sed -i 's/(google.protobuf.EmptyMessage)/(google.protobuf.Empty)/g' {} \;
#find ../../finam -name '*.proto' -exec sed -i 's/\.proto/\.protos/g' {} \;
