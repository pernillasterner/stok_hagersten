

<?php get_header();


global $aveny;
if(isset($wp_query->query_vars['kal'])) {
	$date = urldecode($wp_query->query_vars['kal']);
} else {
	$date = date("Y-m-d");
}
$timestmp = strtotime($date);
$prevDate = $timestmp - 86400;
$nextDate =	$timestmp + 86400;

$dayHeading = strftime("%A %e %B",strtotime($date));
?>

    <div id="wrapper">
            <?php include('page-header.php'); ?>

            <div class="col0">

                <?php include_once('mini-calendar.php'); ?>

                <?php //include('share.php') ;?>

                <div class="clear"></div>

            </div>

            <div class="col1">
                <div class="switch-weeks pie">
                    <a href="<?php print("?kal=".date("Y-m-d",$prevDate));?>" class="week-prev">◄</a>
					<p><?php print($dayHeading);?></p>
                    <a href=<?php print("?kal=".date("Y-m-d",$nextDate));?> class="week-next">►</a>
                </div>

               <table cellspacing="0" cellpadding="0" id="calendarTableWeek">
                    <tbody>
            <?php



                $day = $aveny->get_day($date);
				if (!is_null($day)) {

                	$rows = (sizeof($day) * 2) -1;
                	$newday = true;
                	foreach ($day as $event) {

						print ('<tr>');

                		if ($newday) {
							$newday = false;


							printf ('<td rowspan="%s" class="calendarTimeStamp">',$rows);
                            printf ('<a href="#">%s</a>',strftime("%A %e %h",strtotime($event['frandatum'])));
                            print ('</td>');

                            } else {

                            } // if $newday

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

                        else {
                            print ('<div class="calendar-item pie">');
                            print ('<h1>Det finns inga händelser detta datum</h1>');
                            print ('</div>');
                        }
                ?>

                    </tbody>
                </table>

                <?php include('meta.php');?>

            </div>

            <?php get_sidebar(); ?>

            <?php get_footer(); ?>
