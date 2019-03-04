<?php

namespace Em4nl\U;

require_once(dirname(__DIR__) . '/vendor/autoload.php');

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/mock/header.php';


class send_content_helper_Test extends TestCase {

    protected $preserveGlobalState = FALSE;
    protected $runTestInSeparateProcess = TRUE;

    function test_sets_correct_status_header() {
        global $header_calls;
        $this->assertEmpty($header_calls);
        send_content_helper('', true, '200', 'text/html');
        $this->assertEquals(count($header_calls), 2);
        $this->assertEquals($header_calls[0], 'HTTP/1.1 200 OK');
    }

    function test_sets_correct_content_type_header() {
        global $header_calls;
        $this->assertEmpty($header_calls);
        send_content_helper('', true, '200', 'text/html');
        $this->assertEquals(count($header_calls), 2);
        $this->assertEquals($header_calls[1], 'Content-Type: text/html');
    }

    function test_defines_unplug_response_sent() {
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        send_content_helper('', true, '200', 'text/html');
        $this->assertTrue(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertTrue(UNPLUG_RESPONSE_SENT);
    }
}
