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

class JsonTest extends \PHPUnit_Framework_TestCase
{
    public function testEncode()
    {
        $j = new Json();
        $this->assertEquals(
            '{"foo":"bar"}',
            $j->encode(
                array(
                    'foo' => 'bar'
                )
            )
        );
    }

    public function testPrettyEncode()
    {
        $j = new Json();
        $j->setPrettyPrint(true);
        $e = $j->encode(array('foo' => 'bar'));
        if (defined('JSON_PRETTY_PRINT')) {
            $this->assertEquals("{\n    \"foo\": \"bar\"\n}", $e);
        } else {
            $this->assertEquals('{"foo":"bar"}', $e);
        }
    }

    public function testMoreEncode()
    {
        $j = new Json();
        $this->assertEquals('5', $j->encode(5));
        $this->assertEquals(5, $j->decode('5'));
        $this->assertEquals('null', $j->encode(null));
        $this->assertNull($j->decode('null'));
    }

    public function testDecode()
    {
        $j = new Json();
        $d = $j->decode('{"foo":"bar"}');
        $this->assertEquals(array('foo' => 'bar'), $d);
    }

    /**
     * @expectedException fkooman\Json\Exception\JsonException
     * @expectedExceptionMessage Malformed UTF-8 characters, possibly incorrectly encoded
     */
    public function testBrokenEncode()
    {
        $j = new Json();
        $e = $j->encode(
            array(
                iconv(
                    'UTF-8',
                    'ISO-8859-1',
                    'îïêëì'
                )
            )
        );
    }

    /**
     * @expectedException fkooman\Json\Exception\JsonException
     * @expectedExceptionMessage Syntax error
     */
    public function testBrokenDecode()
    {
        $j = new Json();
        $e = $j->decode("}");
    }

    public function testValidJson()
    {
        $j = new Json();
        $this->assertFalse($j->isJson('}'));
        $this->assertTrue($j->isJson('{}'));
        $this->assertTrue($j->isJson('null'));
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage unable to read file
     */
    public function testDecodeFileMissingFile()
    {
        $j = new Json();
        $j->decodeFile("/foo/bar/baz.json");
    }

    public function testDecodeFile()
    {
        $j = new Json();
        $e = $j->decodeFile(dirname(dirname(__DIR__)) . "/data/data.json");
        $this->assertEquals(array('foo' => 'bar'), $e);
    }
}
