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
    /** @var fkooman\Json\Json */
    private $json;

    public function setUp()
    {
        $this->json = new Json();
    }
    public function testEncode()
    {
        $e = $this->json->encode(array('foo' => 'bar'));
        $this->assertEquals('{"foo":"bar"}', $e);
    }

    public function testPrettyEncode()
    {
        $e = $this->json->encode(array('foo' => 'bar'), true);
        if (defined('JSON_PRETTY_PRINT')) {
            $this->assertEquals("{\n    \"foo\": \"bar\"\n}", $e);
        } else {
            $this->assertEquals('{"foo":"bar"}', $e);
        }
    }

    public function testMoreEncode()
    {
        $this->assertEquals('5', $this->json->encode(5));
        $this->assertEquals(5, $this->json->decode('5'));
        $this->assertEquals('null', $this->json->encode(null));
        $this->assertNull($this->json->decode('null'));
    }

    public function testDecode()
    {
        $d = $this->json->decode('{"foo":"bar"}');
        $this->assertEquals(array('foo' => 'bar'), $d);
    }

    /**
     * @expectedException fkooman\Json\JsonException
     * @expectedExceptionMessage Malformed UTF-8 characters, possibly incorrectly encoded
     */
    public function testBrokenEncode()
    {
        $e = $this->json->encode(
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
     * @expectedException fkooman\Json\JsonException
     * @expectedExceptionMessage Syntax error
     */
    public function testBrokenDecode()
    {
        $e = $this->json->decode("}");
    }

    public function testValidJson()
    {
        $this->assertFalse($this->json->isJson('}'));
        $this->assertTrue($this->json->isJson('{}'));
        $this->assertTrue($this->json->isJson('null'));
    }
}
