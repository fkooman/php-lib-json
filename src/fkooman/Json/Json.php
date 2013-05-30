<?php

/**
* Copyright 2013 François Kooman <fkooman@tuxed.net>
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

class Json
{

    public static function enc($data, $prettyPrint = FALSE)
    {
        $p = 0;
        if ($prettyPrint && defined('JSON_PRETTY_PRINT')) {
            $p |= JSON_PRETTY_PRINT;
        }
        $jsonData = @json_encode($data, $p);
        $jsonError = json_last_error();
        if (JSON_ERROR_NONE !== $jsonError) {
            throw new JsonException($jsonError);
        }

        return $jsonData;
    }

    public static function dec($jsonData, $asArray = TRUE)
    {
        $data = json_decode($jsonData, $asArray ? TRUE : FALSE);
        $jsonError = json_last_error();
        if (JSON_ERROR_NONE !== $jsonError) {
            throw new JsonException($jsonError);
        }

        return $data;
    }

    public static function isJson($jsonData)
    {
        try {
            $data = self::dec($jsonData);

            return TRUE;
        } catch (JsonException $e) {
            return FALSE;
        }
    }
}
