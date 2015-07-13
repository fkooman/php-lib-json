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
    const MESSAGE_JSON_ERROR_NONE  = 'No error has occurred';
    const MESSAGE_JSON_ERROR_DEPTH = 'The maximum stack depth has been exceeded';
    const MESSAGE_JSON_ERROR_STATE_MISMATCH = 'Invalid or malformed JSON';
    const MESSAGE_JSON_ERROR_CTRL_CHAR = 'Control character error, possibly incorrectly encoded';
    const MESSAGE_JSON_ERROR_SYNTAX = 'Syntax error';
    const MESSAGE_JSON_ERROR_UTF8 = 'Malformed UTF-8 characters, possibly incorrectly encoded';
    const MESSAGE_OTHER = 'Other error (%s)';

    /**
     * @param  $data
     * @param  int $encodeOptions
     *
     * @return string
     */
    public static function encode($data, $encodeOptions = 0)
    {
        $jsonData = @json_encode($data, $encodeOptions);
        self::handleJsonError();

        return $jsonData;
    }

    /**
     * @param $jsonData
     * @param bool|true $assocArray
     *
     * @return mixed
     */
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

    /**
     * Decode a json file
     *
     * @param $fileName
     * @param bool|true $assocArray
     *
     * @return mixed
     */
    public static function decodeFile($fileName, $assocArray = true)
    {
        $jsonData = @file_get_contents($fileName);
        if (false === $jsonData) {
            throw new RuntimeException('unable to read file');
        }

        return self::decode($jsonData, $assocArray);
    }

    /**
     * Check whether a json is valid or not
     *
     * @param $jsonData
     *
     * @return bool
     */
    public static function isValidJson($jsonData)
    {
        try {
            self::decode($jsonData);

            return true;
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }

    /**
     * Convert a json error code to string
     *
     * @param $code
     * @return string
     */
    public static function jsonErrorToString($code)
    {
        switch ($code) {
            case JSON_ERROR_NONE:
                return self::MESSAGE_JSON_ERROR_NONE;
            case JSON_ERROR_DEPTH:
                return self::MESSAGE_JSON_ERROR_DEPTH;
            case JSON_ERROR_STATE_MISMATCH:
                return self::MESSAGE_JSON_ERROR_STATE_MISMATCH;
            case JSON_ERROR_CTRL_CHAR:
                return self::MESSAGE_JSON_ERROR_CTRL_CHAR;
            case JSON_ERROR_SYNTAX:
                return self::MESSAGE_JSON_ERROR_SYNTAX;
            case JSON_ERROR_UTF8:
                return self::MESSAGE_JSON_ERROR_UTF8;
            default:
                return sprintf(self::MESSAGE_OTHER, $code);
        }
    }
}
