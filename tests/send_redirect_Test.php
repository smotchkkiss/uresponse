<?php

namespace Em4nl\U;

require_once(dirname(__DIR__) . '/vendor/autoload.php');

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/mock/header.php';


class send_redirect_Test extends TestCase {

    protected $preserveGlobalState = FALSE;
    protected $runTestInSeparateProcess = TRUE;

    function test_defines_do_cache() {
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        send_redirect('/');
        $this->assertTrue(defined('UNPLUG_DO_CACHE'));
    }

    function test_sets_do_cache_false() {
        send_redirect('/');
        $this->assertFalse(UNPLUG_DO_CACHE);
    }

    function test_defines_response_sent() {
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        send_redirect('/');
        $this->assertTrue(defined('UNPLUG_RESPONSE_SENT'));
    }

    function test_sets_response_sent_true() {
        send_redirect('/');
        $this->assertTrue(UNPLUG_RESPONSE_SENT);
    }

    function test_sets_redirect_header() {
        global $header_calls;
        $this->assertEmpty($header_calls);
        send_redirect('/');
        $this->assertEquals(count($header_calls), 2);
        $this->assertEquals(
            'HTTP/1.1 301 Moved Permanently',
            array_shift($header_calls)
        );
    }

    function test_puts_together_the_correct_url_1() {
        global $header_calls;
        send_redirect('https://example.com/');
        $this->assertEquals(
            array_pop($header_calls),
            'Location: https://example.com/'
        );
    }

    function test_puts_together_the_correct_url_2() {
        global $header_calls;
        send_redirect('https://example.com/wurm');
        $this->assertEquals(
            array_pop($header_calls),
            'Location: https://example.com/wurm'
        );
    }

    function test_puts_together_the_correct_url_3() {
        global $header_calls;
        send_redirect('https://example.com/sein/129');
        $this->assertEquals(
            array_pop($header_calls),
            'Location: https://example.com/sein/129'
        );
    }

    function test_puts_together_the_correct_url_4() {
        global $header_calls;
        send_redirect('https://example.com/wurm/sein/0000');
        $this->assertEquals(
            array_pop($header_calls),
            'Location: https://example.com/wurm/sein/0000'
        );
    }

    function test_emits__the_correct_status_1() {
        global $header_calls;
        send_redirect('/');
        $this->assertEquals(
            array_shift($header_calls),
            'HTTP/1.1 301 Moved Permanently'
        );
    }

    function test_emits__the_correct_status_2() {
        global $header_calls;
        send_redirect('/wurm', true);
        $this->assertEquals(
            array_shift($header_calls),
            'HTTP/1.1 301 Moved Permanently'
        );
    }

    function test_emits__the_correct_status_3() {
        global $header_calls;
        send_redirect('/499', false);
        $this->assertEquals(
            array_shift($header_calls),
            'HTTP/1.1 302 Found'
        );
    }
}
