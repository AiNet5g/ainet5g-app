<?php
/** @package LaoSuperLottery */
if (! defined('ABSPATH')) { exit; }
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
  <div class="container header-inner">
    <div class="branding">
      <?php if (has_custom_logo()) { the_custom_logo(); } ?>
      <div>
        <a href="<?php echo esc_url(home_url('/')); ?>"><strong><?php bloginfo('name'); ?></strong></a>
        <div><?php echo esc_html(lao_super_get_setting('site_tagline', get_bloginfo('description'))); ?></div>
      </div>
    </div>
    <button class="mobile-toggle" aria-expanded="false" aria-controls="primary-menu"><?php echo esc_html(lao_super_get_setting('mobile_menu_label', 'เมนู')); ?></button>
    <nav id="primary-menu" class="main-nav" aria-label="Primary Menu">
      <?php wp_nav_menu(array('theme_location' => 'primary', 'container' => false, 'fallback_cb' => false)); ?>
    </nav>
  </div>
  <?php $header_ads = lao_super_get_setting('ads_header_html', ''); if ($header_ads) : ?>
    <div class="container"><?php echo wp_kses_post($header_ads); ?></div>
  <?php endif; ?>
</header>
<main class="container">
