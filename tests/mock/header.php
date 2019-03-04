<?php

namespace Em4nl\U;

// mock the header function
if (!function_exists('Em4nl\U\header')) {
    $header_calls = [];
    function header(
        string $header,
        bool $replace=TRUE,
        int $http_response_code=200
    ) {
        global $header_calls;
        $header_calls[] = $header;
    }
}
