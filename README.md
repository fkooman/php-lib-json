# Introduction
This is a PHP library written to make it easy and safe to process JSON. It will
throw exceptions when encoding or decoding fails.

# Installation
You can use Composer to use this library in your application.

# Tests
You can run the PHPUnit tests if PHPUnit is installed:

    $ phpunit tests/

# API
To use the library, see the example below:

    <?php
    require_once 'vendor/autoload.php';

    use \fkooman\Json\Json;
    use \fkooman\Json\JsonException;

    echo Json::enc("foo") . PHP_EOL;
    echo Json::enc(array("foo" => "bar")) . PHP_EOL;
    echo var_export (Json::dec('{"foo":"bar"}'), TRUE) . PHP_EOL;

    try {
        Json::dec('{');
    } catch (JsonException $e) {
        echo "ERROR: " . $e->getMessage(). PHP_EOL;
    }

This will output the following:

    "foo"
    {"foo":"bar"}
    array (
      'foo' => 'bar',
    )
    ERROR: Syntax error

# License
Licensed under the Apache License, Version 2.0;

   http://www.apache.org/licenses/LICENSE-2.0
