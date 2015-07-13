<?php

/**
 * Copyright 2015 François Kooman <fkooman@tuxed.net>.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace fkooman\Json;

use RuntimeException;
use InvalidArgumentException;

class Json
{
    public static function encode($data, $encodeOptions = 0)
    {
        $jsonData = @json_encode($data, $encodeOptions);
        self::handleJsonError();

        return $jsonData;
    }

    public static function decode($jsonData, $assocArray = true)
    {
        $data = @json_decode($jsonData, $assocArray);
        self::handleJsonError();

        return $data;
    }

    public static function handleJsonError()
    {
        $jsonError = json_last_error();
        if (JSON_ERROR_NONE !== $jsonError) {
            throw new InvalidArgumentException(self::jsonErrorToString($jsonError));
        }
    }

    public static function decodeFile($fileName, $assocArray = true)
    {
        $jsonData = @file_get_contents($fileName);
        if (false === $jsonData) {
            throw new RuntimeException('unable to read file');
        }

        return self::decode($jsonData, $assocArray);
    }

    public static function isValidJson($jsonData)
    {
        try {
            self::decode($jsonData);

            return true;
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }

    public static function jsonErrorToString($code)
    {
        switch ($code) {
            case JSON_ERROR_NONE:
                $msg = 'No error has occurred';
                break;
            case JSON_ERROR_DEPTH:
                $msg = 'The maximum stack depth has been exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $msg = 'Invalid or malformed JSON';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $msg = 'Control character error, possibly incorrectly encoded';
                break;
            case JSON_ERROR_SYNTAX:
                $msg = 'Syntax error';
                break;
            case JSON_ERROR_UTF8:
                $msg = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
            default:
                $msg = "Other error ($code)";
                break;
        }

        return $msg;
    }
}
