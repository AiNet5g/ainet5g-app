<?php
/**
 * Theme settings page.
 *
 * @package LaoSuperLottery
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('admin_menu', function () {
    add_menu_page(
        __('Lao Super Theme', 'lao-super-lottery'),
        __('Lao Super Theme', 'lao-super-lottery'),
        'manage_options',
        'lao-super-theme-settings',
        'lao_super_render_settings_page',
        'dashicons-chart-line',
        61
    );
});

add_action('admin_init', function () {
    register_setting(
        'lao_super_theme_group',
        'lao_super_theme_settings',
        array(
            'type'              => 'array',
            'sanitize_callback' => 'lao_super_sanitize_settings',
            'default'           => array(),
        )
    );
});

function lao_super_sanitize_settings(array $input): array {
    $text_fields = array(
        'site_tagline','homepage_hero_title','homepage_hero_desc','homepage_hero_cta_text','homepage_hero_cta_url',
        'api_endpoint','api_key','fallback_date','fallback_name','fallback_four_digits','seo_meta_title',
        'seo_meta_description','seo_og_image','content_disclaimer','mobile_menu_label','cta_box_title','cta_box_text',
        'logo_preload','hero_preload'
    );

    $textarea_fields = array(
        'fallback_three_digits','fallback_two_digits','content_faq_json','ads_header_html','ads_sidebar_html','custom_head_code','custom_footer_code'
    );

    $result = array();
    foreach ($text_fields as $field) {
        $value = $input[$field] ?? '';
        $result[$field] = in_array($field, array('homepage_hero_cta_url', 'api_endpoint', 'seo_og_image', 'logo_preload', 'hero_preload'), true)
            ? esc_url_raw($value)
            : sanitize_text_field($value);
    }

    foreach ($textarea_fields as $field) {
        $result[$field] = isset($input[$field]) ? wp_kses_post($input[$field]) : '';
    }

    $result['api_timeout'] = isset($input['api_timeout']) ? max(3, min(20, absint($input['api_timeout']))) : 8;
    $result['perf_defer_js'] = empty($input['perf_defer_js']) ? 0 : 1;
    $result['perf_disable_emojis'] = empty($input['perf_disable_emojis']) ? 0 : 1;

    return $result;
}

function lao_super_field(string $key): string {
    $settings = lao_super_get_settings();
    return (string) ($settings[$key] ?? '');
}

function lao_super_render_settings_page(): void {
    if (! current_user_can('manage_options')) {
        wp_die(esc_html__('Unauthorized', 'lao-super-lottery'));
    }
    ?>
    <div class="wrap">
      <h1><?php esc_html_e('Lao Super Theme Settings', 'lao-super-lottery'); ?></h1>
      <form method="post" action="options.php">
        <?php settings_fields('lao_super_theme_group'); ?>

        <h2>Branding</h2>
        <table class="form-table"><tbody>
          <tr><th>Site Tagline</th><td><input class="regular-text" name="lao_super_theme_settings[site_tagline]" value="<?php echo esc_attr(lao_super_field('site_tagline')); ?>"></td></tr>
          <tr><th>Logo Preload URL</th><td><input class="regular-text" name="lao_super_theme_settings[logo_preload]" value="<?php echo esc_attr(lao_super_field('logo_preload')); ?>"></td></tr>
        </tbody></table>

        <h2>Homepage</h2>
        <table class="form-table"><tbody>
          <tr><th>Hero Title</th><td><input class="regular-text" name="lao_super_theme_settings[homepage_hero_title]" value="<?php echo esc_attr(lao_super_field('homepage_hero_title')); ?>"></td></tr>
          <tr><th>Hero Description</th><td><textarea class="large-text" rows="3" name="lao_super_theme_settings[homepage_hero_desc]"><?php echo esc_textarea(lao_super_field('homepage_hero_desc')); ?></textarea></td></tr>
          <tr><th>Hero CTA Text</th><td><input class="regular-text" name="lao_super_theme_settings[homepage_hero_cta_text]" value="<?php echo esc_attr(lao_super_field('homepage_hero_cta_text')); ?>"></td></tr>
          <tr><th>Hero CTA URL</th><td><input class="regular-text" name="lao_super_theme_settings[homepage_hero_cta_url]" value="<?php echo esc_attr(lao_super_field('homepage_hero_cta_url')); ?>"></td></tr>
          <tr><th>Hero Image Preload URL</th><td><input class="regular-text" name="lao_super_theme_settings[hero_preload]" value="<?php echo esc_attr(lao_super_field('hero_preload')); ?>"></td></tr>
        </tbody></table>

        <h2>Lottery Result API</h2>
        <table class="form-table"><tbody>
          <tr><th>API Endpoint</th><td><input class="regular-text" name="lao_super_theme_settings[api_endpoint]" value="<?php echo esc_attr(lao_super_field('api_endpoint')); ?>"></td></tr>
          <tr><th>API Key</th><td><input class="regular-text" type="password" autocomplete="new-password" name="lao_super_theme_settings[api_key]" value="<?php echo esc_attr(lao_super_field('api_key')); ?>"><p class="description">Stored server-side only.</p></td></tr>
          <tr><th>Timeout (3-20 sec)</th><td><input class="small-text" type="number" min="3" max="20" name="lao_super_theme_settings[api_timeout]" value="<?php echo esc_attr((string) lao_super_get_setting('api_timeout', 8)); ?>"></td></tr>
          <tr><th>Fallback Date</th><td><input class="regular-text" name="lao_super_theme_settings[fallback_date]" value="<?php echo esc_attr(lao_super_field('fallback_date')); ?>"></td></tr>
          <tr><th>Fallback Name</th><td><input class="regular-text" name="lao_super_theme_settings[fallback_name]" value="<?php echo esc_attr(lao_super_field('fallback_name')); ?>"></td></tr>
          <tr><th>Fallback 4 Digits</th><td><input class="regular-text" name="lao_super_theme_settings[fallback_four_digits]" value="<?php echo esc_attr(lao_super_field('fallback_four_digits')); ?>"></td></tr>
          <tr><th>Fallback 3 Digits (comma)</th><td><textarea class="large-text" rows="2" name="lao_super_theme_settings[fallback_three_digits]"><?php echo esc_textarea(lao_super_field('fallback_three_digits')); ?></textarea></td></tr>
          <tr><th>Fallback 2 Digits (comma)</th><td><textarea class="large-text" rows="2" name="lao_super_theme_settings[fallback_two_digits]"><?php echo esc_textarea(lao_super_field('fallback_two_digits')); ?></textarea></td></tr>
        </tbody></table>

        <h2>SEO Settings</h2>
        <table class="form-table"><tbody>
          <tr><th>Meta Title</th><td><input class="regular-text" name="lao_super_theme_settings[seo_meta_title]" value="<?php echo esc_attr(lao_super_field('seo_meta_title')); ?>"></td></tr>
          <tr><th>Meta Description</th><td><textarea class="large-text" rows="3" name="lao_super_theme_settings[seo_meta_description]"><?php echo esc_textarea(lao_super_field('seo_meta_description')); ?></textarea></td></tr>
          <tr><th>Open Graph Image URL</th><td><input class="regular-text" name="lao_super_theme_settings[seo_og_image]" value="<?php echo esc_attr(lao_super_field('seo_og_image')); ?>"></td></tr>
        </tbody></table>

        <h2>On-page Content</h2>
        <table class="form-table"><tbody>
          <tr><th>Disclaimer</th><td><textarea class="large-text" rows="4" name="lao_super_theme_settings[content_disclaimer]"><?php echo esc_textarea(lao_super_field('content_disclaimer')); ?></textarea></td></tr>
          <tr><th>FAQ JSON</th><td><textarea class="large-text code" rows="8" name="lao_super_theme_settings[content_faq_json]" placeholder='[{"q":"...","a":"..."}]'><?php echo esc_textarea(lao_super_field('content_faq_json')); ?></textarea></td></tr>
        </tbody></table>

        <h2>Mobile Menu</h2>
        <table class="form-table"><tbody>
          <tr><th>Menu Toggle Label</th><td><input class="regular-text" name="lao_super_theme_settings[mobile_menu_label]" value="<?php echo esc_attr(lao_super_field('mobile_menu_label')); ?>"></td></tr>
        </tbody></table>

        <h2>Ads / CTA</h2>
        <table class="form-table"><tbody>
          <tr><th>CTA Title</th><td><input class="regular-text" name="lao_super_theme_settings[cta_box_title]" value="<?php echo esc_attr(lao_super_field('cta_box_title')); ?>"></td></tr>
          <tr><th>CTA Text</th><td><textarea class="large-text" rows="3" name="lao_super_theme_settings[cta_box_text]"><?php echo esc_textarea(lao_super_field('cta_box_text')); ?></textarea></td></tr>
          <tr><th>Header Ads HTML</th><td><textarea class="large-text code" rows="4" name="lao_super_theme_settings[ads_header_html]"><?php echo esc_textarea(lao_super_field('ads_header_html')); ?></textarea></td></tr>
          <tr><th>Sidebar Ads HTML</th><td><textarea class="large-text code" rows="4" name="lao_super_theme_settings[ads_sidebar_html]"><?php echo esc_textarea(lao_super_field('ads_sidebar_html')); ?></textarea></td></tr>
        </tbody></table>

        <h2>Performance</h2>
        <table class="form-table"><tbody>
          <tr><th>Defer theme JS</th><td><label><input type="checkbox" name="lao_super_theme_settings[perf_defer_js]" value="1" <?php checked((int) lao_super_get_setting('perf_defer_js', 1), 1); ?>> Enable</label></td></tr>
          <tr><th>Disable WP Emojis</th><td><label><input type="checkbox" name="lao_super_theme_settings[perf_disable_emojis]" value="1" <?php checked((int) lao_super_get_setting('perf_disable_emojis', 1), 1); ?>> Enable</label></td></tr>
        </tbody></table>

        <h2>Custom Code</h2>
        <table class="form-table"><tbody>
          <tr><th>Head Code</th><td><textarea class="large-text code" rows="6" name="lao_super_theme_settings[custom_head_code]"><?php echo esc_textarea(lao_super_field('custom_head_code')); ?></textarea></td></tr>
          <tr><th>Footer Code</th><td><textarea class="large-text code" rows="6" name="lao_super_theme_settings[custom_footer_code]"><?php echo esc_textarea(lao_super_field('custom_footer_code')); ?></textarea></td></tr>
        </tbody></table>

        <?php submit_button(__('Save Settings', 'lao-super-lottery')); ?>
      </form>
    </div>
    <?php
}
