<?php get_header(); ?>

    <div id="wrapper">
            <?php include('page-header.php'); ?>
            
            <div class="col0">

                <?php //include('share.php') ;?>

            </div>

            <div class="col1">
               <h1 class="page-title"><?php printf( __( 'Sökresultat för: %s', 'Advantumkompetens' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
        
                <?php
                if (isset($_GET['s']) && $_GET['s'] == ""): // damn ugly hack 
                ?>
                
                <p><?php _e( 'Du måste ange minst ett sökord...', 'Svenska Kyrkan Hägersten' ); ?></p>
                
                <?php else: ?> 
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                        
                        <?php 
                        $singleExcerpt = get_the_title();
                        if (strlen($singleExcerpt) > 0) {
                            print('<hr/>');
                            print('<h2><a href="'.get_permalink().'">'.get_the_title().'</a></h2>');
                            //print ($singleExcerpt);
			    $excerpt = strip_tags(get_the_excerpt()); echo $excerpt;
                        }
                        ?>
                        
                    <?php endwhile; else: ?>
                        <p><?php _e( 'Vi hittade inget som matchar din sökning...', 'Svenska Kyrkan Hägersten' ); ?></p>
                    <?php endif; ?>
                <?php endif;?>
                <?php include('meta.php');?>
            </div>
    <?php get_sidebar(); ?> 

    <?php get_footer(); ?>

	<div id="main">
