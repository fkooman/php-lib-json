# Introduction
This is a PHP library written to make it easy and safe to process JSON. It will
throw exceptions when encoding or decoding fails.

# Installation
You can use [Composer](https://getcomposer.org) and require `fkooman/json` to 
use this library in your application.

# Tests
You can run the PHPUnit tests if PHPUnit is installed:

    $ phpunit tests/

Do not forget to run `/path/to/composer.phar install` first.

# API
To use the library, see the example below:

    <?php
    require_once 'vendor/autoload.php';

    use fkooman\Json\Json;

    echo Json::encode("foo") . PHP_EOL;
    echo Json::encode(array('foo' => 'bar')) . PHP_EOL;
    echo var_export(Json::decode('{"foo":"bar"}')) . PHP_EOL;

    try {
        Json::decode('{');
    } catch (InvalidArgumentException $e) {
        echo "ERROR: " . $e->getMessage(). PHP_EOL;
    }

This will output the following:

    "foo"
    {"foo":"bar"}
    array (
      'foo' => 'bar',
    )
    ERROR: Syntax error

If you want to use encoding parameters of the original `json_encode()` you can
use them "as is" as the second parameter to `Json::encode()`. By default this
library returns arrays when decoding JSON. If you want to for objects make the
second parameter of `Json::decode()` `false`.

# License
Licensed under the Apache License, Version 2.0;

   http://www.apache.org/licenses/LICENSE-2.0
