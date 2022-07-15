				<div id="eyebrow">
                    <a href="/" class="logotype">Svensk Kyrkan Hägersten</a>
                    <a href="#" class="menu-icon border-icon">menu icon</a>
					<?php get_search_form(); ?>
				</div>
				<div id="inner-wrapper">

				<header class="site-header">
					<nav class="main-menu pie">
                        <?php get_search_form(); ?>
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'link-pie', 'depth' => 3) ); ?>
					</nav>
				</header>
