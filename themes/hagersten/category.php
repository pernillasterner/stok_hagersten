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

                <?php //include('share.php') ;?>

            </div>

            <div class="col1">
               <h1><?php echo single_cat_title(); ?></h1>
                <!-- starta loopen -->
                <?php while ( have_posts() ) : the_post(); ?>
                    
                
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <?php /*<div class="post-meta">
                            <time><?php echo get_the_date(); ?></time>
                        </div><!-- slut post-meta -->*/ ?>
                        
                        <div class="post-content">
                            <header class="post-header">
                                <h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permalänk till <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                            </header>
                    
                            <?php if ( is_archive() || is_search() ) : // Visa bara ett utdrag på arkiv- och sök-sidorna ?>
                            <div class="post-utdrag">
                               
                                    <?php
				    if(has_post_thumbnail()) :?>
				    <aside class="pie">
                                        <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');  ?>
                                        <a href="<?php the_permalink() ?>"><img class="pie" src="<?php echo $thumb[0]; ?>" /></a>
                                    </aside>
				    <?php the_excerpt(); ?>
				    
				    <?php else :?>
				    <div class="no-thumb"><?php the_excerpt(); ?></div>
				    <?php endif;?>
				    
				
				  
                     
                                
                                <a class="read-more" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                            </div><!-- slut post-utdrag -->
                            
                        <?php endif; ?> 
                        
                        </div><!-- slut post-content -->
                        
                        
                        
                        
                        
                    </article>

		
		    <?php endwhile; ?>
		
		    <div id="previousposts" class="alignleft"><?php previous_posts_link('&laquo; Föregående inlägg') ?></div>		
		    <div id="moreposts" class="alignright"><?php next_posts_link('Fler inlägg &raquo;','') ?></div>
 
            </div>
    <?php get_sidebar(); ?> 

    <?php get_footer(); ?>

    <script type="text/javascript">

    $(document).ready(function() {
	    $('.col1').infinitescroll({

		    //callback		: function () { console.log('using opts.callback'); },
		    navSelector  	: "div#moreposts a",
		    nextSelector 	: "div#moreposts a",
		    itemSelector 	: ".col1 article",
		    debug		 	: true,
		    dataType	 	: 'html',
		    //localMode 		: true,
		    animate			: false,
		    extraScrollPx	: 0,
		    bufferPx		: 10,
		    // behavior		: 'twitter',
		    //appendCallback	: false, // USE FOR PREPENDING
		    //pathParse     	: function( pathStr, nextPage ){ return pathStr.replace('2', nextPage ); }
	}, function(newElements){

	    //USE FOR PREPENDING
	    // $(newElements).css('background-color','#ffef00');
	    // $(this).prepend(newElements);
	    //
	    //END OF PREPENDING

	    window.console && console.log('context: ',this);
	    window.console && console.log('returned: ', newElements);

	});
    });

    </script>




