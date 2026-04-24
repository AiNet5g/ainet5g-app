<?php
/**
 * Schema and SEO tags.
 *
 * @package LaoSuperLottery
 */

if (! defined('ABSPATH')) {
    exit;
}

function lao_super_breadcrumb_items(): array {
    $items = array(
        array('name' => 'หน้าแรก', 'url' => home_url('/')),
    );
    if (is_singular()) {
        $items[] = array('name' => get_the_title(), 'url' => get_permalink());
    }
    return $items;
}

add_action('wp_head', function () {
    $title = lao_super_get_setting('seo_meta_title', get_bloginfo('name'));
    $desc = lao_super_get_setting('seo_meta_description', get_bloginfo('description'));
    $og_image = lao_super_get_setting('seo_og_image', '');

    echo '<meta name="description" content="' . esc_attr($desc) . '">';
    echo '<meta property="og:title" content="' . esc_attr($title) . '">';
    echo '<meta property="og:description" content="' . esc_attr($desc) . '">';
    echo '<meta property="og:type" content="website">';
    echo '<meta property="og:url" content="' . esc_url(home_url(add_query_arg(array(), $GLOBALS['wp']->request ?? ''))) . '">';
    if ($og_image) {
        echo '<meta property="og:image" content="' . esc_url($og_image) . '">';
    }

    $org = array(
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => get_bloginfo('name'),
        'url' => home_url('/'),
        'description' => $desc,
    );

    $website = array(
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => get_bloginfo('name'),
        'url' => home_url('/'),
        'potentialAction' => array(
            '@type' => 'SearchAction',
            'target' => home_url('/?s={search_term_string}'),
            'query-input' => 'required name=search_term_string',
        ),
    );

    $breadcrumbs = lao_super_breadcrumb_items();
    $breadcrumb_schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => array_values(array_map(function ($item, $index) {
            return array(
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url'],
            );
        }, $breadcrumbs, array_keys($breadcrumbs))),
    );

    $article = null;
    if (is_single()) {
        $article = array(
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => get_the_title(),
            'datePublished' => get_the_date(DATE_W3C),
            'dateModified' => get_the_modified_date(DATE_W3C),
            'author' => array('@type' => 'Person', 'name' => get_the_author()),
        );
    }

    $faq_schema = null;
    $faq_raw = lao_super_get_setting('content_faq_json', '');
    $faqs = json_decode($faq_raw, true);
    if (is_array($faqs) && ! empty($faqs)) {
        $faq_schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_values(array_map(function ($item) {
                return array(
                    '@type' => 'Question',
                    'name' => sanitize_text_field($item['q'] ?? ''),
                    'acceptedAnswer' => array(
                        '@type' => 'Answer',
                        'text' => sanitize_text_field($item['a'] ?? ''),
                    ),
                );
            }, $faqs)),
        );
    }

    $all = array_filter(array($org, $website, $breadcrumb_schema, $article, $faq_schema));
    foreach ($all as $schema) {
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
    }
}, 20);
