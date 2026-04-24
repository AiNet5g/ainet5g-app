<?php
/** @package LaoSuperLottery */
get_header();
?>
<div class="breadcrumb"><a href="<?php echo esc_url(home_url('/')); ?>">หน้าแรก</a> / <?php the_title(); ?></div>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <article class="page-content">
    <h1><?php the_title(); ?></h1>
    <?php the_content(); ?>
  </article>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
