##Php gRPC
Php обертка над корпоративным grpc пакетами для доступа к корпоративным grpc сервисам

**Реализовано:**

\PhpGrpc\TXSecurities::search($query, $lang, $limit) - аналог сервиса https://txprd-wt.just2trade.com/securities/search?query=tsl&lang=ru, но grpc не поддерживает получение всех инструментов

\PhpGrpc\MDStream::getQuotesByFinamId($finamId)

Для инициализации \PhpGrpc\TXSecurities и \PhpGrpc\MDStream необходимо указать хост и порт сервиса из Consul

Consul - система для поиска микросервисов - https://consul.entapp.work/ui/. Для доступа нужен нужен ACL-токен.

На данный момент сервисы развернут на адресах

dc-ny/services/prd-srhr03-txsecurities:
* 10.200.128.148:35554
* 10.200.160.149:35554

tst-ft-marketdata:
* msa-ftcd1-tst02:5666


В данном пакете используются:
* https://git.finam.ru/projects/SER/repos/grpc-proto/browse
* https://git.finam.ru/projects/SER/repos/grpc-txsecurities/browse
* https://git.finam.ru/projects/SER/repos/grpc-marketdata/browse
* https://git.finam.ru/projects/SER/repos/grpc-transaq/browse

Полный список корпоративных grpc пакетов - https://git.finam.ru/projects/SER
