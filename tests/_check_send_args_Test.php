<?php

namespace Em4nl\U;

require_once dirname(__DIR__) . '/vendor/autoload.php';

use PHPUnit\Framework\TestCase;


class _check_send_args_Test extends TestCase {

    /**
     * @doesNotPerformAssertions
     */
    function test_check_send_args_accepts_valid_args() {
        _check_send_args('', true, '200');
        _check_send_args('', false, '200');
        _check_send_args('', true, '404');
        _check_send_args('', false, '404');
        _check_send_args('some text', true, '200');
        _check_send_args('other text', false, '200');
        _check_send_args('some text', true, '404');
        _check_send_args('other text', false, '404');
    }

    function test_check_send_args_throws_wrong_body_type1() {
        $this->expectException(\Exception::class);
        _check_send_args(0, true, '200');
    }

    function test_check_send_args_throws_wrong_body_type2() {
        $this->expectException(\Exception::class);
        _check_send_args(true, true, '200');
    }

    function test_check_send_args_throws_wrong_body_type3() {
        $this->expectException(\Exception::class);
        _check_send_args(NULL, true, '200');
    }

    function test_check_send_args_throws_wrong_body_type4() {
        $this->expectException(\Exception::class);
        _check_send_args(new \StdClass(), true, '200');
    }

    function test_check_send_args_throws_wrong_cacheable_type1() {
        $this->expectException(\Exception::class);
        _check_send_args('', '', '200');
    }

    function test_check_send_args_throws_wrong_cacheable_type2() {
        $this->expectException(\Exception::class);
        _check_send_args('', null, '200');
    }

    function test_check_send_args_throws_wrong_cacheable_type3() {
        $this->expectException(\Exception::class);
        _check_send_args('', array(), '200');
    }

    function test_check_send_args_throws_wrong_cacheable_type4() {
        $this->expectException(\Exception::class);
        _check_send_args('', 144, '200');
    }

    function test_check_send_args_throws_wrong_cacheable_type5() {
        $this->expectException(\Exception::class);
        _check_send_args('', new \StdClass(), '200');
    }

    function test_check_send_args_throws_wrong_status_type1() {
        $this->expectException(\Exception::class);
        _check_send_args('', true, 200);
    }

    function test_check_send_args_throws_wrong_status_type2() {
        $this->expectException(\Exception::class);
        _check_send_args('', true, array('wurm' => 89));
    }

    function test_check_send_args_throws_wrong_status_type3() {
        $this->expectException(\Exception::class);
        _check_send_args('', true, new \StdClass());
    }

    function test_check_send_args_throws_wrong_status_type4() {
        $this->expectException(\Exception::class);
        _check_send_args('', true, NULL);
    }

    function test_check_send_args_throws_wrong_status_type5() {
        $this->expectException(\Exception::class);
        _check_send_args('', true, false);
    }
}
