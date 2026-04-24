<?php
/**
 * Theme bootstrap.
 *
 * @package LaoSuperLottery
 */

if (! defined('ABSPATH')) {
    exit;
}

define('LAO_SUPER_THEME_VERSION', '1.0.0');
define('LAO_SUPER_THEME_DIR', get_template_directory());
define('LAO_SUPER_THEME_URI', get_template_directory_uri());

require_once LAO_SUPER_THEME_DIR . '/inc/theme-setup.php';
require_once LAO_SUPER_THEME_DIR . '/inc/theme-settings.php';
require_once LAO_SUPER_THEME_DIR . '/inc/api.php';
require_once LAO_SUPER_THEME_DIR . '/inc/shortcodes.php';
require_once LAO_SUPER_THEME_DIR . '/inc/schema.php';
require_once LAO_SUPER_THEME_DIR . '/inc/helpers.php';
