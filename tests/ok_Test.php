<?php

namespace Em4nl\U;

require_once(dirname(__DIR__) . '/vendor/autoload.php');

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/mock/header.php';


class ok_Test extends TestCase {

    protected $preserveGlobalState = FALSE;
    protected $runTestInSeparateProcess = TRUE;

    function test_sends_empty_html_without_args() {
        global $header_calls;
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        ob_start();
        ok();
        $this->assertEquals(ob_get_clean(), '');
        $this->assertEquals(array_shift($header_calls), 'HTTP/1.1 200 OK');
        $this->assertEquals(array_shift($header_calls), 'Content-Type: text/html');
        $this->assertTrue(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertTrue(defined('UNPLUG_DO_CACHE'));
        $this->assertTrue(UNPLUG_RESPONSE_SENT);
        $this->assertTrue(UNPLUG_DO_CACHE);
    }

    function test_sends_the_html_from_first_arg() {
        global $header_calls;
        $html = '<h1>WURM</h1>';
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        ob_start();
        ok($html);
        $this->assertEquals(ob_get_clean(), $html);
        $this->assertEquals(array_shift($header_calls), 'HTTP/1.1 200 OK');
        $this->assertEquals(array_shift($header_calls), 'Content-Type: text/html');
        $this->assertTrue(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertTrue(defined('UNPLUG_DO_CACHE'));
        $this->assertTrue(UNPLUG_RESPONSE_SENT);
        $this->assertTrue(UNPLUG_DO_CACHE);
    }

    function test_sets_the_cache_flag_true_correctly() {
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        ob_start();
        ok('', true);
        ob_end_clean();
        $this->assertTrue(defined('UNPLUG_DO_CACHE'));
        $this->assertTrue(UNPLUG_DO_CACHE);
    }

    function test_sets_the_cache_flag_false_correctly() {
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        ob_start();
        ok('', FALSE);
        ob_end_clean();
        $this->assertTrue(defined('UNPLUG_DO_CACHE'));
        $this->assertFalse(UNPLUG_DO_CACHE);
    }

    function test_sends_json_when_called_with_array() {
        $data = array(5, 6, 7, 8, 9);
        ob_start();
        ok($data);
        $output = ob_get_clean();
        $this->assertEquals(json_encode($data), $output);
    }

    function test_throws_when_called_with_wrong_first_arg_1() {
        $this->expectException(\Exception::class);
        ok(NULL);
    }

    function test_throws_when_called_with_wrong_first_arg_2() {
        $this->expectException(\Exception::class);
        ok(true);
    }

    function test_throws_when_called_with_wrong_first_arg_3() {
        $this->expectException(\Exception::class);
        ok(-0.1);
    }

    function test_throws_when_called_with_wrong_first_arg_4() {
        $this->expectException(\Exception::class);
        ok(new \StdClass());
    }

    function test_throws_when_called_with_wrong_second_arg_1() {
        $this->expectException(\Exception::class);
        ok('', 1);
    }

    function test_throws_when_called_with_wrong_second_arg_2() {
        $this->expectException(\Exception::class);
        ok('', null);
    }

    function test_throws_when_called_with_wrong_second_arg_3() {
        $this->expectException(\Exception::class);
        ok('', new \StdClass());
    }

    function test_throws_when_called_with_wrong_second_arg_4() {
        $this->expectException(\Exception::class);
        ok('', 'wurm');
    }

    function test_throws_when_called_with_wrong_second_arg_5() {
        $this->expectException(\Exception::class);
        ok('', []);
    }
}
