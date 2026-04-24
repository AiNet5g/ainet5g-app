<?php
/**
 * Theme setup and assets.
 *
 * @package LaoSuperLottery
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'gallery', 'caption', 'style', 'script'));

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'lao-super-lottery'),
        'mobile'  => __('Mobile Menu', 'lao-super-lottery'),
    ));
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('lao-super-style', get_stylesheet_uri(), array(), LAO_SUPER_THEME_VERSION);
    wp_enqueue_script('lao-super-main', LAO_SUPER_THEME_URI . '/assets/js/main.js', array(), LAO_SUPER_THEME_VERSION, true);
});

add_filter('script_loader_tag', function ($tag, $handle, $src) {
    if ('lao-super-main' !== $handle || ! (int) lao_super_get_setting('perf_defer_js', 1)) {
        return $tag;
    }
    return '<script src="' . esc_url($src) . '" defer></script>';
}, 10, 3);

add_action('init', function () {
    if (! (int) lao_super_get_setting('perf_disable_emojis', 1)) {
        return;
    }
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
});

add_action('wp_head', function () {
    $logo = lao_super_get_setting('logo_preload', '');
    $hero = lao_super_get_setting('hero_preload', '');
    if ($logo) {
        echo '<link rel="preload" as="image" href="' . esc_url($logo) . '">';
    }
    if ($hero) {
        echo '<link rel="preload" as="image" href="' . esc_url($hero) . '">';
    }

    $custom = lao_super_get_setting('custom_head_code', '');
    if ($custom) {
        echo wp_kses($custom, array(
            'script' => array('type' => true, 'src' => true, 'async' => true, 'defer' => true),
            'style'  => array(),
            'meta'   => array('name' => true, 'content' => true, 'property' => true),
            'link'   => array('rel' => true, 'href' => true, 'as' => true, 'type' => true),
        ));
    }
}, 5);

add_action('wp_footer', function () {
    $custom = lao_super_get_setting('custom_footer_code', '');
    if ($custom) {
        echo wp_kses($custom, array(
            'script' => array('type' => true, 'src' => true, 'async' => true, 'defer' => true),
            'noscript' => array(),
            'iframe' => array('src' => true, 'height' => true, 'width' => true, 'style' => true),
        ));
    }
});

add_filter('the_content', function ($content) {
    return str_replace('<img ', '<img loading="lazy" decoding="async" ', $content);
}, 20);
