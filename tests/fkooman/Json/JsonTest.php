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

use PHPUnit_Framework_TestCase;

class JsonTest extends PHPUnit_Framework_TestCase
{
    public function testEncode()
    {
        $this->assertEquals(
            '{"foo":"bar"}',
            Json::encode(
                array(
                    'foo' => 'bar',
                )
            )
        );
    }

    public function testMoreEncode()
    {
        $this->assertEquals('5', Json::encode(5));
        $this->assertEquals(5, Json::decode('5'));
        $this->assertEquals('null', Json::encode(null));
        $this->assertNull(Json::decode('null'));
    }

    public function testDecode()
    {
        $d = Json::decode('{"foo":"bar"}');
        $this->assertEquals(array('foo' => 'bar'), $d);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Malformed UTF-8 characters, possibly incorrectly encoded
     */
    public function testBrokenEncode()
    {
        $e = Json::encode(
            array(
                iconv(
                    'UTF-8',
                    'ISO-8859-1',
                    'îïêëì'
                ),
            )
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Syntax error
     */
    public function testBrokenDecode()
    {
        $e = Json::decode('}');
    }

    public function testValidJson()
    {
        $this->assertFalse(Json::isValidJson('}'));
        $this->assertTrue(Json::isValidJson('{}'));
        $this->assertTrue(Json::isValidJson('null'));
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage unable to read file
     */
    public function testDecodeFileMissingFile()
    {
        Json::decodeFile('/foo/bar/baz.json');
    }

    public function testDecodeFile()
    {
        $e = Json::decodeFile(dirname(dirname(__DIR__)).'/data/data.json');
        $this->assertEquals(array('foo' => 'bar'), $e);
    }

    public function testForceObject()
    {
        $this->assertEquals('{}', Json::encode(array(), JSON_FORCE_OBJECT));
    }
}
