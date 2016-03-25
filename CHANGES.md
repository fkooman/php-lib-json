# Changelog

## 2.0.0 (...)
- go back to `JsonException` instead of `InvalidArgumentException`
- introduce `encodeFile()`

## 1.0.0
- update dependencies
- source formatting

## 0.6.0
- back to static methods
- use PHP's JSON options for encoding (also second parameter to 
  `Json::encode()`
- remove `JsonException`, throw `InvalidArgumentException` instead on error
- rename `isJson()` to `isValidJson()`

## 0.5.1
- default should not forceObject

## 0.5.0
- new API
- back to objects
- support pretty print, force object and return as assoc array now as 
  class setters instead of parameters
- move `JsonException` to `fkooman\Json\Exception` namespace
- rename `decodeFromFile()` to `decodeFile()`

## 0.4.1
- add Json::decodeFromFile() method

## 0.4.0
- add COPYING file
- change name of package to fkooman/json from fkooman/php-lib-json

## 0.3.0
- new API (back to static methods)
- remove `enc()` and `dec()`

## 0.2.0
- new API
- no longer use static methods
- prefer `encode()` and `decode()` now, but aliases `enc()` and `dec()` still 
  exist

## 0.1.0
- initial release
