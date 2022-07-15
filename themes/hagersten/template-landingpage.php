<?php
/**********************
Template Name: Landningssida
**********************/ ?>

<?php get_header(); ?>

    <div id="wrapper">
        <?php include('page-header.php'); ?>

        <div class="col1">

            <?php 
            $i = 1;
            $last_class = "last";
            while(the_repeater_field('landingpage-boxar')): 
            ?>

                <div class="landingpage-puff skeden pie <?php the_sub_field('landingpage-box-color'); ?> <?php if ($i++ % 2 == 0) echo $last_class;?>" onclick="location.href='<?php the_sub_field('landingpage-link'); ?>'">
                    <img class="pie" src="<?php the_sub_field('landingpage-img'); ?>" />
                     <div class="landingpage-puff-text skeden pie"><a href="<?php the_sub_field('landingpage-link'); ?>"><?php the_sub_field('landingpage-text'); ?></a></div>  
                </div>
            <?php endwhile; ?>
            


        </div>
        <?php get_sidebar(); ?> 

        <?php get_footer(); ?>

	<div id="main">
