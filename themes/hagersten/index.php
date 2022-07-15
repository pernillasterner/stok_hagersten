<?php get_header(); ?>

    <div id="wrapper">
            <?php include('page-header.php'); ?>

            <div class="col0">
                <?php include('submenu.php');?>

                <?php //include('share.php') ;?>

            </div>

            <div class="col1">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                    <?php
                        if (strlen(get_field('long_title')) > 0) {
                    ?>
                    <h1><?php the_field('long_title'); ?></h1>
                    <?php } else{ ?>
                        <h1><?php the_title(); ?></h1>
                    <?php } ?>

                    <?php if (function_exists('has_excerpt') && has_excerpt()) the_excerpt(); ?>
                    <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'big'); if ( has_post_thumbnail() ) { ?>
                    <img class="featured-image pie" src="<?php echo $thumb[0]; ?>" alt="<?php the_title(); ?>" /> <?php } ?>
                    <?php include('meta.php');?>
                    <?php the_content(); ?>

                <?php endwhile; else: ?>
                        Det finns inget innehåll på denna sida
                <?php endif; ?>

                
            </div>
    <?php get_sidebar(); ?>

    <?php get_footer(); ?>

	<div id="main">
