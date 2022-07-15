<?php

$args = array(
	'post_type' => 'page',
	'showposts' => 1,
	'meta_key' => '_wp_page_template',
	'meta_value' => 'template-social-media.php'
);

$wpQuery = new WP_Query( $args );
$page = reset( $wpQuery->posts );

$socials = get_field( 'smp_sidebar_social_links', $page->ID );

if( $socials ) :
?>
<ul class="solcialMedia">
	<?php foreach( $socials as $social ) : ?>
	<li>
		<a href="<?php echo $social['link']; ?>" target="_blank">
			<span class="icon icon-<?php echo strtolower( $social['name'] ); ?>"></span>
		</a>
	</li>
	<?php endforeach; ?>
</ul>
<?php endif;