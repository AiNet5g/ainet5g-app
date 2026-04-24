<?php
/** @package LaoSuperLottery */
if (! defined('ABSPATH')) { exit; }
?>
</main>
<footer class="site-footer">
  <div class="container" style="padding:1rem 0">
    <div class="cta">
      <strong><?php echo esc_html(lao_super_get_setting('cta_box_title', '')); ?></strong>
      <p><?php echo esc_html(lao_super_get_setting('cta_box_text', '')); ?></p>
      <p><?php echo esc_html(lao_super_get_setting('content_disclaimer', '')); ?></p>
    </div>
    <small>&copy; <?php echo esc_html(gmdate('Y')); ?> <?php bloginfo('name'); ?></small>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
