<?php
/** @package LaoSuperLottery */
get_header();
$result = lao_super_fetch_latest_result();
?>
<div class="breadcrumb"><a href="<?php echo esc_url(home_url('/')); ?>">หน้าแรก</a></div>
<section class="hero">
  <h1><?php echo esc_html(lao_super_get_setting('homepage_hero_title', '')); ?></h1>
  <p><?php echo esc_html(lao_super_get_setting('homepage_hero_desc', '')); ?></p>
  <p><a href="<?php echo esc_url(lao_super_get_setting('homepage_hero_cta_url', home_url('/'))); ?>"><?php echo esc_html(lao_super_get_setting('homepage_hero_cta_text', '')); ?></a></p>
</section>

<div class="grid" style="margin-top:1rem;">
  <div class="col-8">
    <?php echo do_shortcode('[lao_super_result]'); ?>
    <?php echo do_shortcode('[lao_super_history days="7"]'); ?>
    <?php echo do_shortcode('[lao_super_faq]'); ?>
  </div>
  <aside class="col-4 card">
    <h3>สรุปผลล่าสุด</h3>
    <p><?php echo esc_html($result['date']); ?></p>
    <p><strong><?php echo esc_html($result['results']['four_digits']); ?></strong></p>
    <?php $sidebar_ads = lao_super_get_setting('ads_sidebar_html', ''); if ($sidebar_ads) { echo wp_kses_post($sidebar_ads); } ?>
  </aside>
</div>
<?php get_footer(); ?>
