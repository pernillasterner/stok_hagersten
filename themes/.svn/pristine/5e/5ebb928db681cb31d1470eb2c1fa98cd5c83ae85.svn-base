
get_header(); ?>	

<div class="content" id="content">	
	<div class="wrapper">
		<div class="inner-wrapper shadow padding">
			<?php
				// GET CUSTOM HEADING (if any)
				$rubrik = get_field('sidrubrik'); if( $rubrik ) { ?>
				<h1><?php the_field('sidrubrik'); ?></h1>
			<?php } else { ?>
				<h1><?php the_title(); ?></h1>
			<?php } ?>
			
			<h2><?php the_field('underrubrik');?></h2>
		</div>
		
		<div class="line-shadow"></div>
		
		<div class="one-half">
		    <?php while ( have_posts() ) : the_post(); ?>
			<?php the_content(); ?>
		    <?php endwhile;
		    wp_reset_postdata();
		    ?>
		</div>
		<div class="one-half no-margin">
			<div class="margin-container">
		
			</div>
		</div>
		
	</div>
</div>


<div class="content">
	<div class="wrapper">
		<div class="inner-wrapper shadow padding">
			<?php get_footer(); ?>
		</div>
	</div>
</div>