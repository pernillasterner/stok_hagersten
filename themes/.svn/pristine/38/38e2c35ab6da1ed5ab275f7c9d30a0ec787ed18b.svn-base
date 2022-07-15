<?php
/**********************
Template Name: Nyhetsbrev registreringsformulär
**********************/ ?>

<?php get_header(); ?>

    <div id="wrapper">
            <?php include('page-header.php'); ?>
            
            <div class="col0">
                <?php include('submenu.php');?>

                <?php include('share.php') ;?>

            </div>

            <div class="col1">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                    <?php the_content(); ?>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?><?php endif; ?>
                
                <?php endwhile; else: ?>
                        Det finns inget innehåll på denna sida
                    <?php endif; ?>
                <?php include('meta.php');?>
            </div>
    <?php get_sidebar(); ?> 

    <?php get_footer(); ?>

	<div id="main">
