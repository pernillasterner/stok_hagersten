<?php get_header(); ?>

<div id="wrapper">
	<?php include( realpath( dirname( __FILE__ ) ) . '/../page-header.php' ); ?>

	<div class="col0">
		<?php include( realpath( dirname( __FILE__ ) ) . '/../submenu.php' ); ?>
	</div>

	<div class="col1">
		<?php
		
		if( have_posts() ) :
		
		$title = ( strlen( get_field( 'long_title' ) ) > 0 ) ? get_field( 'long_title' ) : get_the_title(); ?>
		
		<h1><?php echo $title; ?></h1>
		
		<?php
		
		if( function_exists( 'has_excerpt' ) && has_excerpt() ) {
			the_excerpt();
		}
		?>
		
		<?php
		
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'big' );
		
		if( has_post_thumbnail() ) :
		?>
		<img class="featured-image pie" src="<?php echo $thumb[0]; ?>" alt="<?php echo $title; ?>" />
		<?php endif; ?>
		
		<?php echo apply_filters( 'the_content', $post->post_content ); ?>
		
		<?php else: ?>
		Det finns inget innehåll på denna sida
		<?php endif; ?>
		
		<?php
		
		$socials = get_field( 'smp_social_links' );
		
		if( $socials ) : ?>
		<div class="custom-row">
			<?php foreach( $socials as $social ) : ?>
			<div class="custom-col-sm-2">
				<span class="icon icon-<?php echo strtolower( $social['name'] ); ?>"></span>
			</div>
			<div class="custom-col-sm-8">
				<?php echo apply_filters( 'the_content', $social['text'] ); ?>
			</div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>

		<div class="clearefix"></div>
		
		<br>
		
		<?php include( realpath( dirname( __FILE__ ) ) . '/../meta.php' ); ?>
	</div>
	
	<?php
	
	get_sidebar();
	get_footer();
	?>
	
    <div id="main">