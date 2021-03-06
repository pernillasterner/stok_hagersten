<?php get_header(); 

global $aveny;

if(isset($wp_query->query_vars['kal'])) {
	$kal =  urldecode($wp_query->query_vars['kal']);
	
	if (preg_match("/^\d{4}\-\d{1,2}\-\d{1,2}/", $kal)) {
		// match nnnn-nn-nn Typical yyyy-mm-dd
		$date = $kal;
                
	} elseif (preg_match("/^\d{4}\-\d{1,2}/", $kal)) {
		// match nnnn-(n)n Typical yyyy-ww
		$parts = explode("-",$kal);
		$year = $parts[0];
		$week = $parts[1];
		$datetime = new DateTime();
		$datetime->setISODate($year,$week);
		$date = $datetime->format('Y-m-d');
                
	} elseif (preg_match("/^\d{2}/", $kal)) {
			// match nn Typical ww
		$week = $kal;
		$date = date("Y-m-d",strtotime("2012W$kal"));
		
	} else {
		$date = date("Y-m-d");
	}
} else {
	$date = date("Y-m-d");
}

$week = "".intval(date("W", strtotime($date)));

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
			<a href="<?php print ("?kal=".date("Y-W", strtotime($date)-604800));?>" class="week-prev">◄</a>
			<p>Vecka <?php print($week);?></p>
			<a href="<?php print ("?kal=".date("Y-W", strtotime($date)+604800));?>" class="week-next">►</a>
		</div>
		
		<table cellspacing="0" cellpadding="0" id="calendarTableWeek">
			<tbody>                
				
				<?php 

				
				$week = $aveny->get_week($date);
				foreach ($week as $day) {
					
					if (!is_null($day)) {
						
						$rows = (sizeof($day) * 2) -1 ;
						$newday = true;
						foreach ($day as $event) {

							print ('<tr>');
							
							if ($newday) {
								$newday = false;

								printf ('<td rowspan="%s" class="calendarTimeStamp">',$rows);
								printf ('<a href="#">%s</a>',strftime("%A %e %h",strtotime($event['frandatum'])));
								print ('</td>');
								
							} else { } // if $newday
							
							print ('<td class="spacer"></td>');
							
							print ('<td class="calendarEventContainer">');
							printf ('<span class="date">%s</span>',$event['frantid']);
							printf ('<a href="/kalender/handelse?no=%s">%s »</a>',$event['id'],$event['titel']);
							printf ('<em>%s</em>', $event['plats_namn']);
							printf ('<p>%s</p>', $event['notering']);
							print ('</td>');
							print ('</tr>');
							
							print ('<tr>');	                        
							print ('<td colspan="3" class="spacer">&nbsp;</td>');
							print ('</tr>');
							
						} // foreach
						print ('<tr>');
						print ('<td colspan="3" class="spacer">&nbsp;</td>');
						print ('</tr>'); 
					} 
				}
				
				?>
				
			</tbody>
		</table>
		<?php include('meta.php');?>
	</div>
	<?php get_sidebar(); ?> 
	<?php get_footer(); ?>