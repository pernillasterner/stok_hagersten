<?php

$args = array(
	'post_type' => 'instagram',
	'posts_per_page' => 12
);

$wpQuery = new WP_Query( $args );

if( $wpQuery->posts ) :
?>
<div class="ins-wrap">
	<h2><?php echo get_post_meta( $post->ID, 'ins_title', true ); ?></h2>
	
	<div class="iw-img-wrap">
		<?php foreach( $wpQuery->posts as $instagram ) : 
			
			$imageLink = get_post_meta( $instagram->ID, 'instagram_link', true );
				
		?>
		<div class="img-iw">
			<?php if( has_post_thumbnail( $instagram ) ) : ?>
			<?php 
				if( $imageLink ) {
					echo '<a href="' . $imageLink . '" target="_blank" rel="nofollow noopener">';
				}  
			?>
			<img src="<?php echo get_the_post_thumbnail_url( $instagram, '209x209' ); ?>" alt="<?php echo $instagram->post_title; ?>">
			<?php 
				if( $imageLink ) {
					echo '</a>';
				} 
			?>
			<?php endif; ?>
		</div>
		<?php endforeach; ?>
	</div>
	
	<a href="<?php echo get_post_meta( $post->ID, 'ins_link', true ); ?>" target="_blank" class="sm-pic">
		<?php echo get_post_meta( $post->ID, 'ins_link_text', true ); ?>
	</a>
</div>
<?php endif;