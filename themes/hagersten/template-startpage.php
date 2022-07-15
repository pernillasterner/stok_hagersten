<?php
/**********************
Template Name: Startsida
**********************/ ?>

<?php get_header(); ?>

<div id="wrapper">
	<?php include('page-header.php'); ?>

	<div class="col1">
		<div id="carousel">
			<div class="navi"></div>
			<div class="scrollable" id="browsable">
				<div class="items">
					<?php query_posts('cat=3&showposts=4'); ?>
					<?php if (have_posts()) : while (have_posts()) : the_post();  ?>
					  <article class="item" onclick="location.href='<?php the_permalink() ?>'">
						<div class="carousel-text">
							<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
							<p><?php echo excerpt(23);?><a href="<?php the_permalink() ?>">Läs mer..</a></p>
						</div>
						<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'big');  ?>
						<img class="pie" src="<?php echo $thumb[0]; ?>" alt="<?php the_title(); ?>" />
					</article>
					<?php endwhile; endif; wp_reset_query();?>
				</div>
			</div>
		</div>

		<div class="carousel-mobile">
			<div class="scrollable">
				<div class="items2">
					<?php query_posts('cat=3&showposts=4'); ?>
					<?php if (have_posts()) : while (have_posts()) : the_post();  ?>
					  <article class="item" onclick="location.href='<?php the_permalink() ?>'">
						<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'big');  ?>
														<img class="pie" src="<?php echo $thumb[0]; ?>" alt="<?php the_title(); ?>" />
						<div class="carousel-text">
							<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
							<p><?php echo excerpt(20);?><a href="<?php the_permalink() ?>">Läs mer..</a></p>
						</div>


					</article>
					<?php endwhile; endif; wp_reset_query();?>
				</div>
			</div>
		</div>

		<?php query_posts('cat=-3&showposts=6'); ?>
		<?php
			$i = 1;
			$last_class = "last";
			if (have_posts()) : while (have_posts()) : the_post();
		?>
		<article class="first-page-puff pie <?php if ($i++ % 3 == 0) echo $last_class;?>">
			<a href="<?php the_permalink() ?>">
				<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail'); if ( has_post_thumbnail() ) {  ?>
				<img class="pie" src="<?php echo $thumb[0]; ?>" alt="<?php the_title(); ?>" /><?php } else { ?>
				<img class="default-img" src="<?php bloginfo('template_url'); ?>/bilder/default-article-img.png" />
				<?php } ?>
			</a>
			<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
			<p><?php echo excerpt(12);?></p>
			<a href="<?php the_permalink() ?>" class="puff-read-more">Läs mer</a>
		</article>
		<?php endwhile; endif; wp_reset_query();?>

		<div class="clear"></div>

		<a class="boxed-link pie margin-top no-margin-right" href="/artiklar/">Fler nyheter</a>

		<div class="clear"></div>

		<?php get_template_part( 'templates/includes/instagram-part' ); ?>
	</div>

	<?php
	
	get_sidebar();
	get_footer();
