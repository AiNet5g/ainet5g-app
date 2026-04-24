<?php
/**
 * API integration.
 *
 * @package LaoSuperLottery
 */

if (! defined('ABSPATH')) {
    exit;
}

function lao_super_get_fallback_result(): array {
    return array(
        'date' => lao_super_get_setting('fallback_date', ''),
        'name' => lao_super_get_setting('fallback_name', 'หวยลาวซุปเปอร์'),
        'results' => array(
            'four_digits' => lao_super_get_setting('fallback_four_digits', ''),
            'three_digits' => lao_super_parse_csv_numbers(lao_super_get_setting('fallback_three_digits', '')),
            'two_digits' => lao_super_parse_csv_numbers(lao_super_get_setting('fallback_two_digits', '')),
        ),
        'source' => 'fallback',
    );
}

function lao_super_fetch_latest_result(bool $force_refresh = false): array {
    $cache_key = 'lao_super_latest_result';
    if (! $force_refresh) {
        $cached = get_transient($cache_key);
        if (is_array($cached) && ! empty($cached['date'])) {
            return $cached;
        }
    }

    $endpoint = lao_super_get_setting('api_endpoint', '');
    if (! $endpoint) {
        return lao_super_get_fallback_result();
    }

    $args = array(
        'timeout' => (int) lao_super_get_setting('api_timeout', 8),
        'headers' => array('Accept' => 'application/json'),
    );

    $api_key = lao_super_get_setting('api_key', '');
    if ($api_key) {
        $args['headers']['Authorization'] = 'Bearer ' . $api_key;
    }

    $response = wp_remote_get($endpoint, $args);
    if (is_wp_error($response)) {
        return lao_super_get_fallback_result();
    }

    $code = wp_remote_retrieve_response_code($response);
    $body = wp_remote_retrieve_body($response);
    if (200 !== $code || ! $body) {
        return lao_super_get_fallback_result();
    }

    $decoded = json_decode($body, true);
    if (! is_array($decoded) || empty($decoded['results'])) {
        return lao_super_get_fallback_result();
    }

    $result = array(
        'date' => sanitize_text_field($decoded['date'] ?? ''),
        'name' => sanitize_text_field($decoded['name'] ?? 'หวยลาวซุปเปอร์'),
        'results' => array(
            'four_digits' => sanitize_text_field($decoded['results']['four_digits'] ?? ''),
            'three_digits' => array_map('sanitize_text_field', (array) ($decoded['results']['three_digits'] ?? array())),
            'two_digits' => array_map('sanitize_text_field', (array) ($decoded['results']['two_digits'] ?? array())),
        ),
        'source' => 'api',
    );

    set_transient($cache_key, $result, HOUR_IN_SECONDS);
    return $result;
}
