<?php get_header(); ?>

    <div id="wrapper">
            <?php include('page-header.php'); ?>

            <div class="col0">
		<nav class="sub-menu pie">

		    <ul>
		    <?php wp_list_categories('orderby=name&style=list&include=4& title_li='); ?>
		    <?php wp_list_categories('child_of=4&orderby=name&style=list&exclude=1,3& title_li='); ?>
		    </ul>
		</nav>
				</nav>

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

			<?php
				$allow_comments = get_field('activate_comments');
				if(!empty($allow_comments) && $allow_comments == 'Ja') :
			?>

            	<div class="fb-comments" data-href="<?php echo get_permalink(); ?>" data-numposts="5" data-width="100%"></div>

			<?php
				endif;
			?>

            </div>
    <?php get_sidebar(); ?>

    <?php get_footer(); ?>


