<?php

namespace Em4nl\U;


if (!function_exists('Em4nl\U\_check_send_args')) {
    function _check_send_args($body, $is_cacheable, $status) {
        if (!is_string($body) && !is_array($body)) {
            throw new \Exception('$body must be a string or an array');
        }
        if (!is_bool($is_cacheable)) {
            throw new \Exception('$is_cacheable must be a boolean');
        }
        if (!is_string($status)) {
            throw new \Exception('$status must be a string');
        }
    }
}


if (!function_exists('Em4nl\U\_set_do_cache_if_undefined')) {
    function _set_do_cache_if_undefined($is_cacheable) {
        if (!defined('UNPLUG_DO_CACHE')) {
            define('UNPLUG_DO_CACHE', $is_cacheable);
        }
    }
}


if (!function_exists('Em4nl\U\status_header')) {
    // a WordPress-ism
    function status_header($status) {
        if ($status === '200') {
            header('HTTP/1.1 200 OK');
        } elseif ($status === '404') {
            header('HTTP/1.1 404 Not Found');
        }
    }
}


if (!function_exists('Em4nl\U\send_content_helper')) {
    function send_content_helper($body, $is_cacheable, $status, $content_type) {
        _check_send_args($body, $is_cacheable, $status);
        _set_do_cache_if_undefined($is_cacheable);
        status_header($status);
        header("Content-Type: $content_type");
        define('UNPLUG_RESPONSE_SENT', TRUE);
    }
}


if (!function_exists('Em4nl\U\send_text')) {
    function send_text($body, $is_cacheable, $status) {
        send_content_helper($body, $is_cacheable, $status, 'text/plain');
        echo $body;
    }
}


if (!function_exists('Em4nl\U\send_html')) {
    function send_html($body, $is_cacheable, $status) {
        send_content_helper($body, $is_cacheable, $status, 'text/html');
        echo $body;
    }
}


if (!function_exists('Em4nl\U\send_json')) {
    function send_json($body, $is_cacheable, $status) {
        send_content_helper($body, $is_cacheable, $status, 'application/json');
        echo json_encode($body);
    }
}


if (!function_exists('Em4nl\U\send_xml')) {
    function send_xml($body, $is_cacheable, $status) {
        send_content_helper($body, $is_cacheable, $status, 'text/xml');
        echo $body;
    }
}


if (!function_exists('Em4nl\U\send_content_response')) {
    function send_content_response($response, $is_cacheable=TRUE, $found=TRUE) {
        if (!is_bool($found)) {
            throw new \Exception('$found must be boolean');
        }

        $status = $found ? '200' : '404';

        if (defined('UNPLUG_RESPONSE_SENT') && UNPLUG_RESPONSE_SENT) {
            return;
        }

        if (is_string($response)) {
            send_html($response, $is_cacheable, $status);
        } elseif (is_array($response)) {
            send_json($response, $is_cacheable, $status);
        } else {
            throw new \Exception('$response must be string or array');
        }
    }
}


if (!function_exists('Em4nl\U\send_redirect')) {
    function send_redirect($location, $is_permanent=TRUE) {
        if (!is_string($location)) {
            throw new \Exception('$location must be a string');
        }
        if (!is_bool($is_permanent)) {
            throw new \Exception('$is_permanent must be a boolean');
        }

        if (defined('UNPLUG_RESPONSE_SENT') && UNPLUG_RESPONSE_SENT) {
            return;
        }

        _set_do_cache_if_undefined(FALSE);

        define('UNPLUG_RESPONSE_SENT', TRUE);

        if ($is_permanent) {
            header('HTTP/1.1 301 Moved Permanently');
            header("Location: $location", true, 301);
        } else {
            header('HTTP/1.1 302 Found');
            header("Location: $location", true, 302);
        }
    }
}


/**
 * Convenience functions for use in routes
 */

if (!function_exists('Em4nl\U\ok')) {
    function ok($response='', $is_cacheable=true) {
        send_content_response($response, $is_cacheable);
    }
}

if (!function_exists('Em4nl\U\not_found')) {
    function not_found($response='') {
        send_content_response($response, FALSE, FALSE);
    }
}

if (!function_exists('Em4nl\U\moved_permanently')) {
    function moved_permanently($location) {
        send_redirect($location);
    }
}

if (!function_exists('Em4nl\U\found')) {
    function found($location) {
        send_redirect($location, false);
    }
}
