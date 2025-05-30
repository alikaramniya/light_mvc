<?php

if (!function_exists('html')) {
    function html(?string $text = null): string
    {
        return htmlspecialchars($text ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('asset')) {
    function asset(string $url)
    {
        if (file_exists(PUBLIC_PATH . '/' . $url)) {
            return $url;
        }
    }
}

if (!function_exists('showError')) {
    function showError(?array $field)
    {
        $res = isset($field) ? implode(', ', $field) : '';

        return "<span style='color:red'>$res</span><br/>";
    }
}
