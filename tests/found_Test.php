<?php

namespace Em4nl\U;

require_once(dirname(__DIR__) . '/vendor/autoload.php');

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/mock/header.php';


class found_Test extends TestCase {

    protected $preserveGlobalState = FALSE;
    protected $runTestInSeparateProcess = TRUE;

    function test_defines_do_cache() {
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        found('http://example.com');
        $this->assertTrue(defined('UNPLUG_DO_CACHE'));
    }

    function test_sets_do_cache_false() {
        found('http://example.com');
        $this->assertFalse(UNPLUG_DO_CACHE);
    }

    function test_defines_response_sent() {
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        found('http://example.com');
        $this->assertTrue(defined('UNPLUG_RESPONSE_SENT'));
    }

    function test_sets_response_sent_true() {
        found('http://example.com');
        $this->assertTrue(UNPLUG_RESPONSE_SENT);
    }

    function test_sets_redirect_header() {
        global $header_calls;
        $this->assertEmpty($header_calls);
        found('http://example.com');
        $this->assertEquals(count($header_calls), 2);
        $this->assertEquals(
            'HTTP/1.1 302 Found',
            array_shift($header_calls)
        );
    }

    function test_throws_when_called_without_url() {
        $this->expectException(\ArgumentCountError::class);
        found();
    }

    function test_puts_together_the_correct_url_1_1() {
        global $header_calls;
        found('https://example.com/');
        $this->assertEquals(
            array_pop($header_calls),
            'Location: https://example.com/'
        );
    }

    function test_puts_together_the_correct_url_2() {
        global $header_calls;
        found('https://example.com/wurm');
        $this->assertEquals(
            array_pop($header_calls),
            'Location: https://example.com/wurm/'
        );
    }

    function test_puts_together_the_correct_url_3() {
        global $header_calls;
        found('https://example.com/sein/129');
        $this->assertEquals(
            array_pop($header_calls),
            'Location: https://example.com/sein/129/'
        );
    }

    function test_puts_together_the_correct_url_4() {
        global $header_calls;
        found('https://example.com/wurm/sein/0000');
        $this->assertEquals(
            array_pop($header_calls),
            'Location: https://example.com/wurm/sein/0000/'
        );
    }

    function test_emits__the_correct_status_1() {
        global $header_calls;
        found('https://example.com');
        $this->assertEquals(
            'HTTP/1.1 302 Found',
            array_shift($header_calls)
        );
    }

    function test_throws_when_called_with_wrong_type_1() {
        $this->expectException(\Exception::class);
        found(null);
    }

    function test_throws_when_called_with_wrong_type_2() {
        $this->expectException(\Exception::class);
        found(0.000007);
    }

    function test_throws_when_called_with_wrong_type_3() {
        $this->expectException(\Exception::class);
        found(array(0, 0, 0, 0,));
    }

    function test_throws_when_called_with_wrong_type_4() {
        $this->expectException(\Exception::class);
        found(new \StdClass());
    }

    function test_throws_when_called_with_wrong_type_5() {
        $this->expectException(\Exception::class);
        found(false);
    }
}
