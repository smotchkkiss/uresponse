<?php

namespace Em4nl\U;

require_once(dirname(__DIR__) . '/vendor/autoload.php');

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/mock/header.php';


class send_content_response_Test extends TestCase {

    protected $preserveGlobalState = FALSE;
    protected $runTestInSeparateProcess = TRUE;

    function test_sends_html_response_with_string_single_arg() {
        global $header_calls;
        $this->assertEmpty($header_calls);
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        ob_start();
        send_content_response('WuRM');
        $output = ob_get_clean();
        $this->assertEquals(count($header_calls), 2);
        $this->assertEquals($header_calls[0], 'HTTP/1.1 200 OK');
        $this->assertEquals($header_calls[1], 'Content-Type: text/html');
        $this->assertTrue(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertTrue(defined('UNPLUG_DO_CACHE'));
        $this->assertTrue(UNPLUG_RESPONSE_SENT);
        $this->assertTrue(UNPLUG_DO_CACHE);
        $this->assertEquals($output, 'WuRM');
    }

    function test_sends_html_response_with_string_single_arg_2() {
        global $header_calls;
        $this->assertEmpty($header_calls);
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        ob_start();
        send_content_response('');
        $output = ob_get_clean();
        $this->assertEquals(count($header_calls), 2);
        $this->assertEquals($header_calls[0], 'HTTP/1.1 200 OK');
        $this->assertEquals($header_calls[1], 'Content-Type: text/html');
        $this->assertTrue(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertTrue(defined('UNPLUG_DO_CACHE'));
        $this->assertTrue(UNPLUG_RESPONSE_SENT);
        $this->assertTrue(UNPLUG_DO_CACHE);
        $this->assertEquals($output, '');
    }

    function test_sends_json_response_with_array_single_arg() {
        global $header_calls;
        $data = array('test1' => false, 'test2' => ['w' => 908]);
        $this->assertEmpty($header_calls);
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        ob_start();
        send_content_response($data);
        $output = ob_get_clean();
        $this->assertEquals(count($header_calls), 2);
        $this->assertEquals($header_calls[0], 'HTTP/1.1 200 OK');
        $this->assertEquals($header_calls[1], 'Content-Type: application/json');
        $this->assertTrue(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertTrue(defined('UNPLUG_DO_CACHE'));
        $this->assertTrue(UNPLUG_RESPONSE_SENT);
        $this->assertTrue(UNPLUG_DO_CACHE);
        $this->assertEquals(json_encode($data), $output);
    }

    function test_sends_json_response_with_array_single_arg_2() {
        global $header_calls;
        $data = array();
        $this->assertEmpty($header_calls);
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        ob_start();
        send_content_response($data);
        $output = ob_get_clean();
        $this->assertEquals(count($header_calls), 2);
        $this->assertEquals($header_calls[0], 'HTTP/1.1 200 OK');
        $this->assertEquals($header_calls[1], 'Content-Type: application/json');
        $this->assertTrue(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertTrue(defined('UNPLUG_DO_CACHE'));
        $this->assertTrue(UNPLUG_RESPONSE_SENT);
        $this->assertTrue(UNPLUG_DO_CACHE);
        $this->assertEquals('[]', $output);
    }

    function test_throws_with_single_arg_wrong_type_1() {
        global $header_calls;
        $this->assertEmpty($header_calls);
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        $this->expectException(\Exception::class);
        send_content_response(null);
        $this->assertEmpty($header_calls);
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
    }

    function test_throws_with_single_arg_wrong_type_2() {
        global $header_calls;
        $this->assertEmpty($header_calls);
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        $this->expectException(\Exception::class);
        send_content_response(true);
        $this->assertEmpty($header_calls);
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
    }

    function test_throws_with_single_arg_wrong_type_3() {
        global $header_calls;
        $this->assertEmpty($header_calls);
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        $this->expectException(\Exception::class);
        send_content_response(-89.3);
        $this->assertEmpty($header_calls);
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
    }

    function test_throws_with_single_arg_wrong_type_4() {
        global $header_calls;
        $this->assertEmpty($header_calls);
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        $this->expectException(\Exception::class);
        send_content_response(new \StdClass());
        $this->assertEmpty($header_calls);
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
    }

    function test_sends_html_response_with_two_args_1() {
        global $header_calls;
        $this->assertEmpty($header_calls);
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        ob_start();
        send_content_response('WuRM', true);
        $output = ob_get_clean();
        $this->assertEquals(count($header_calls), 2);
        $this->assertEquals($header_calls[0], 'HTTP/1.1 200 OK');
        $this->assertEquals($header_calls[1], 'Content-Type: text/html');
        $this->assertTrue(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertTrue(defined('UNPLUG_DO_CACHE'));
        $this->assertTrue(UNPLUG_RESPONSE_SENT);
        $this->assertTrue(UNPLUG_DO_CACHE);
        $this->assertEquals($output, 'WuRM');
    }

    function test_sends_html_response_with_two_args_2() {
        global $header_calls;
        $this->assertEmpty($header_calls);
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        ob_start();
        send_content_response('', true);
        $output = ob_get_clean();
        $this->assertEquals(count($header_calls), 2);
        $this->assertEquals($header_calls[0], 'HTTP/1.1 200 OK');
        $this->assertEquals($header_calls[1], 'Content-Type: text/html');
        $this->assertTrue(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertTrue(defined('UNPLUG_DO_CACHE'));
        $this->assertTrue(UNPLUG_RESPONSE_SENT);
        $this->assertTrue(UNPLUG_DO_CACHE);
        $this->assertEquals($output, '');
    }

    function test_passes_cacheable_arg_correctly_1() {
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        ob_start();
        send_content_response('ouwdawdfp@@#-0230-', false);
        ob_end_clean();
        $this->assertTrue(defined('UNPLUG_DO_CACHE'));
        $this->assertFalse(UNPLUG_DO_CACHE);
    }

    function test_passes_cacheable_arg_correctly_2() {
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        ob_start();
        send_content_response(['wurm' => 'habicht'], false);
        ob_end_clean();
        $this->assertTrue(defined('UNPLUG_DO_CACHE'));
        $this->assertFalse(UNPLUG_DO_CACHE);
    }

    function test_sends_json_response_with_two_args_1() {
        global $header_calls;
        $data = array();
        $this->assertEmpty($header_calls);
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        ob_start();
        send_content_response($data, true);
        $output = ob_get_clean();
        $this->assertEquals(count($header_calls), 2);
        $this->assertEquals($header_calls[0], 'HTTP/1.1 200 OK');
        $this->assertEquals($header_calls[1], 'Content-Type: application/json');
        $this->assertTrue(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertTrue(defined('UNPLUG_DO_CACHE'));
        $this->assertTrue(UNPLUG_RESPONSE_SENT);
        $this->assertTrue(UNPLUG_DO_CACHE);
        $this->assertEquals('[]', $output);
    }

    function test_sends_json_response_with_two_args_2() {
        global $header_calls;
        $data = ['notos' => 9090, 'j' => new \StdClass()];
        $this->assertEmpty($header_calls);
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        ob_start();
        send_content_response($data, false);
        $output = ob_get_clean();
        $this->assertEquals(count($header_calls), 2);
        $this->assertEquals($header_calls[0], 'HTTP/1.1 200 OK');
        $this->assertEquals($header_calls[1], 'Content-Type: application/json');
        $this->assertTrue(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertTrue(defined('UNPLUG_DO_CACHE'));
        $this->assertTrue(UNPLUG_RESPONSE_SENT);
        $this->assertFalse(UNPLUG_DO_CACHE);
        $this->assertEquals(json_encode($data), $output);
    }

    function test_sends_html_response_with_three_args_1() {
        global $header_calls;
        $this->assertEmpty($header_calls);
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        ob_start();
        send_content_response('WuRM', true, true);
        $output = ob_get_clean();
        $this->assertEquals(count($header_calls), 2);
        $this->assertEquals($header_calls[0], 'HTTP/1.1 200 OK');
        $this->assertEquals($header_calls[1], 'Content-Type: text/html');
        $this->assertTrue(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertTrue(defined('UNPLUG_DO_CACHE'));
        $this->assertTrue(UNPLUG_RESPONSE_SENT);
        $this->assertTrue(UNPLUG_DO_CACHE);
        $this->assertEquals($output, 'WuRM');
    }

    function test_sends_html_response_with_three_args_2() {
        global $header_calls;
        $this->assertEmpty($header_calls);
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        ob_start();
        send_content_response('', false, true);
        $output = ob_get_clean();
        $this->assertEquals(count($header_calls), 2);
        $this->assertEquals($header_calls[0], 'HTTP/1.1 200 OK');
        $this->assertEquals($header_calls[1], 'Content-Type: text/html');
        $this->assertTrue(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertTrue(defined('UNPLUG_DO_CACHE'));
        $this->assertTrue(UNPLUG_RESPONSE_SENT);
        $this->assertFalse(UNPLUG_DO_CACHE);
        $this->assertEquals($output, '');
    }

    function test_sends_html_response_with_three_args_3() {
        global $header_calls;
        $this->assertEmpty($header_calls);
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        ob_start();
        send_content_response('WuRM', true, false);
        $output = ob_get_clean();
        $this->assertEquals(count($header_calls), 2);
        $this->assertEquals($header_calls[0], 'HTTP/1.1 404 Not Found');
        $this->assertEquals($header_calls[1], 'Content-Type: text/html');
        $this->assertTrue(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertTrue(defined('UNPLUG_DO_CACHE'));
        $this->assertTrue(UNPLUG_RESPONSE_SENT);
        $this->assertTrue(UNPLUG_DO_CACHE);
        $this->assertEquals($output, 'WuRM');
    }

    function test_sends_json_response_with_three_args_1() {
        global $header_calls;
        $data = array('hy', 37, 600, true, true, NULL);
        $this->assertEmpty($header_calls);
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        ob_start();
        send_content_response($data, true, true);
        $output = ob_get_clean();
        $this->assertEquals(count($header_calls), 2);
        $this->assertEquals($header_calls[0], 'HTTP/1.1 200 OK');
        $this->assertEquals($header_calls[1], 'Content-Type: application/json');
        $this->assertTrue(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertTrue(defined('UNPLUG_DO_CACHE'));
        $this->assertTrue(UNPLUG_RESPONSE_SENT);
        $this->assertTrue(UNPLUG_DO_CACHE);
        $this->assertEquals(json_encode($data), $output);
    }

    function test_sends_json_response_with_three_args_2() {
        global $header_calls;
        $o = new \StdClass();
        $data = [new \StdClass(), new \StdClass(), $o, $o, $o];
        $this->assertEmpty($header_calls);
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        ob_start();
        send_content_response($data, false, true);
        $output = ob_get_clean();
        $this->assertEquals(count($header_calls), 2);
        $this->assertEquals($header_calls[0], 'HTTP/1.1 200 OK');
        $this->assertEquals($header_calls[1], 'Content-Type: application/json');
        $this->assertTrue(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertTrue(defined('UNPLUG_DO_CACHE'));
        $this->assertTrue(UNPLUG_RESPONSE_SENT);
        $this->assertFalse(UNPLUG_DO_CACHE);
        $this->assertEquals(json_encode($data), $output);
    }

    function test_sends_json_response_with_three_args_3() {
        global $header_calls;
        $data = ['a' => ['b' => ['c' => ['d' => ['e' => []]]]]];
        $this->assertEmpty($header_calls);
        $this->assertFalse(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertFalse(defined('UNPLUG_DO_CACHE'));
        ob_start();
        send_content_response($data, false, false);
        $output = ob_get_clean();
        $this->assertEquals(count($header_calls), 2);
        $this->assertEquals($header_calls[0], 'HTTP/1.1 404 Not Found');
        $this->assertEquals($header_calls[1], 'Content-Type: application/json');
        $this->assertTrue(defined('UNPLUG_RESPONSE_SENT'));
        $this->assertTrue(defined('UNPLUG_DO_CACHE'));
        $this->assertTrue(UNPLUG_RESPONSE_SENT);
        $this->assertFalse(UNPLUG_DO_CACHE);
        $this->assertEquals(json_encode($data), $output);
    }

    function test_throws_with_non_boolean_third_arg_1() {
        $this->expectException(\Exception::class);
        send_content_response('', true, 80129287123);
    }

    function test_throws_with_non_boolean_third_arg_2() {
        $this->expectException(\Exception::class);
        send_content_response([], true, NULL);
    }

    function test_throws_with_non_boolean_third_arg_3() {
        $this->expectException(\Exception::class);
        send_content_response('oiawd92eouh2e0wf', true, '');
    }

    function test_throws_with_non_boolean_third_arg_4() {
        $this->expectException(\Exception::class);
        send_content_response(['a' => 'a'], false, new \StdClass());
    }

    function test_throws_with_non_boolean_third_arg_5() {
        $this->expectException(\Exception::class);
        send_content_response('', true, array('uoiwue', 6, 6, NULL));
    }

    function test_throws_with_non_boolean_second_arg_1() {
        $this->expectException(\Exception::class);
        send_content_response('', 0);
    }

    function test_throws_with_non_boolean_second_arg_2() {
        $this->expectException(\Exception::class);
        send_content_response('', NULL, true);
    }

    function test_throws_with_non_boolean_second_arg_3() {
        $this->expectException(\Exception::class);
        send_content_response(array(), array(), false);
    }

    function test_throws_with_non_boolean_second_arg_4() {
        $this->expectException(\Exception::class);
        send_content_response('zaphod', 'BEEBLEBROX');
    }

    function test_throws_with_non_boolean_second_arg_5() {
        $this->expectException(\Exception::class);
        send_content_response([], new \StdClass(), true);
    }

    function test_throws_with_wrong_type_first_arg_1() {
        $this->expectException(\Exception::class);
        send_content_response(new \StdClass, false, true);
    }

    function test_throws_with_wrong_type_first_arg_2() {
        $this->expectException(\Exception::class);
        send_content_response(true, true, true);
    }

    function test_throws_with_wrong_type_first_arg_3() {
        $this->expectException(\Exception::class);
        send_content_response(null, true);
    }

    function test_throws_with_wrong_type_first_arg_4() {
        $this->expectException(\Exception::class);
        send_content_response(-10000000000000000000, false);
    }
}
