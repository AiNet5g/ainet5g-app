<?php
/** @package LaoSuperLottery */
get_header();
?>
<div class="breadcrumb"><a href="<?php echo esc_url(home_url('/')); ?>">หน้าแรก</a> / บทความ</div>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <article class="entry-content" style="margin-bottom:1rem;">
    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <p><?php echo esc_html(get_the_date()); ?></p>
    <?php the_excerpt(); ?>
  </article>
<?php endwhile; else : ?>
  <div class="entry-content"><p>ไม่พบบทความ</p></div>
<?php endif; ?>
<?php get_footer(); ?>
