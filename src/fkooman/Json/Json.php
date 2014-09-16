<?php

/**
* Copyright 2014 François Kooman <fkooman@tuxed.net>
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
use fkooman\Json\Exception\JsonException;

class Json
{
    private $forceObject;
    private $prettyPrint;
    private $returnAssocArray;

    public function __construct()
    {
        $this->forceObject = true;
        $this->prettyPrint = false;
        $this->returnAssocArray = true;
    }

    public function setForceObject($forceObject)
    {
        $this->forceObject = (bool) $forceObject;
    }

    public function setPrettyPrint($prettyPrint)
    {
        $this->prettyPrint = (bool) $prettyPrint;
    }

    public function setReturnAssocArray($returnAssocArray)
    {
        $this->returnAssocArray = (bool) $returnAssocArray;
    }

    public function encode($data)
    {
        $jsonOptions = 0;
        if ($this->prettyPrint && defined('JSON_PRETTY_PRINT')) {
            $jsonOptions |= JSON_PRETTY_PRINT;
        }
        if ($this->forceObject && defined('JSON_FORCE_OBJECT')) {
            $jsonOptions |= JSON_FORCE_OBJECT;
        }

        $jsonData = @json_encode($data, $jsonOptions);
        $jsonError = json_last_error();
        if (JSON_ERROR_NONE !== $jsonError) {
            throw new JsonException($jsonError);
        }

        return $jsonData;
    }

    public function decode($jsonData)
    {
        $data = json_decode($jsonData, $this->returnAssocArray);
        $jsonError = json_last_error();
        if (JSON_ERROR_NONE !== $jsonError) {
            throw new JsonException($jsonError);
        }

        return $data;
    }

    public function decodeFile($fileName)
    {
        $jsonData = @file_get_contents($fileName);
        if (false === $jsonData) {
            throw new RuntimeException("unable to read file");
        }

        return $this->decode($jsonData);
    }

    public function isJson($jsonData)
    {
        try {
            $data = $this->decode($jsonData);

            return true;
        } catch (JsonException $e) {
            return false;
        }
    }
}
