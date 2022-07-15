
<?php get_header();

	/* 
	Template Name: Konsertkalender-sida
	*/

	global $aveny;
	$week = '';
	                
	/*
	if(isset($wp_query->query_vars['kal'])) {
		$kal =  urldecode($wp_query->query_vars['kal']);
	}
	*/
	$kal = "";
	
	if(isset($_GET['kal'])) {
		$kal =  $_GET['kal'];
	}
	$date = date("Y-m-d");
	
	$locale_captions = array (
		"upky" => "Uppenbarelsekyrkan",
		"grky" => "Gröndals kyrka",
		"mäky" => "Mälarhöjdens kyrka",
		"mvky" => "Kvarterskyrkan i Marievik"
	);
	$locale = $locale_captions[$kal];
	
	$args = array (
		"location" => $kal,
		"category" => "Konsert"
	);
                	
	$concerts = $aveny->get_by_location($args);
	
?>

    <div id="wrapper">
            <?php include('page-header.php'); ?>
            
            <div class="col0">
		
		<?php include('mini-calendar.php'); ?>


                <?php //include('share.php') ;?>

                <div class="clear"></div>

            </div>
   
            <div class="col1">
                <div class="switch-weeks pie">
                    <p>konserter i <?php print($locale); ?></p>
                </div>
         
			 	<table cellspacing="0" cellpadding="0" id="calendarTableWeek">
                    <tbody>                
                
                <?php 

                

 
                foreach ($concerts as $event) {
                	
                print ('<div class="calendar-item pie">');
                    printf ('<h1>%s %s - %s</h1>',strftime("%A %e %h",strtotime($event['frandatum'])), $event['frantid'], $event['tilltid']);
                    printf ('<strong>%s</strong>', $event['titel']);
                    printf ('<em>%s</em>', $event['plats_namn']);
                    printf ('%s', $event['notering']);
                print ('</div>');
   				}
 
                ?>
                                        
                    </tbody>
                </table>
                <?php include('meta.php');?>
            </div>
            <?php get_sidebar(); ?> 
            <?php get_footer(); ?>