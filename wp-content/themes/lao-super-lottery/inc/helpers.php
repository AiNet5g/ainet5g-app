<?php
/**
 * Helpers.
 *
 * @package LaoSuperLottery
 */

if (! defined('ABSPATH')) {
    exit;
}

function lao_super_get_settings(): array {
    $defaults = array(
        'site_tagline'             => 'เว็บไซต์ข้อมูลผลหวยลาวซุปเปอร์ สถิติ และบทความความรู้',
        'homepage_hero_title'      => 'อัปเดตผลหวยลาวซุปเปอร์',
        'homepage_hero_desc'       => 'เน้นการให้ข้อมูลเพื่อการวิเคราะห์อย่างรับผิดชอบ ไม่ชักชวนการพนันผิดกฎหมาย',
        'homepage_hero_cta_text'   => 'ดูผลล่าสุด',
        'homepage_hero_cta_url'    => home_url('/'),
        'api_endpoint'             => '',
        'api_key'                  => '',
        'api_timeout'              => 8,
        'fallback_date'            => '',
        'fallback_name'            => 'หวยลาวซุปเปอร์',
        'fallback_four_digits'     => '',
        'fallback_three_digits'    => '',
        'fallback_two_digits'      => '',
        'seo_meta_title'           => get_bloginfo('name'),
        'seo_meta_description'     => get_bloginfo('description'),
        'seo_og_image'             => '',
        'content_disclaimer'       => 'เนื้อหานี้จัดทำเพื่อให้ข้อมูลเท่านั้น ผู้ใช้งานควรใช้วิจารณญาณ และปฏิบัติตามกฎหมายในพื้นที่ของตน',
        'content_faq_json'         => '',
        'mobile_menu_label'        => 'เมนู',
        'cta_box_title'            => 'ติดตามผลอย่างมีสติ',
        'cta_box_text'             => 'ศึกษาสถิติย้อนหลังและจัดการงบประมาณอย่างรับผิดชอบ',
        'ads_header_html'          => '',
        'ads_sidebar_html'         => '',
        'perf_defer_js'            => 1,
        'perf_disable_emojis'      => 1,
        'custom_head_code'         => '',
        'custom_footer_code'       => '',
        'logo_preload'             => '',
        'hero_preload'             => '',
    );

    $saved = get_option('lao_super_theme_settings', array());
    return wp_parse_args(is_array($saved) ? $saved : array(), $defaults);
}

function lao_super_get_setting(string $key, $default = '') {
    $settings = lao_super_get_settings();
    return $settings[$key] ?? $default;
}

function lao_super_parse_csv_numbers(string $value): array {
    $parts = array_filter(array_map('trim', explode(',', $value)));
    return array_values($parts);
}
