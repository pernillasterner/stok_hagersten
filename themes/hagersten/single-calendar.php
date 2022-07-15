
<?php get_header(); ?>

    <div id="wrapper">
            <?php include('page-header.php'); ?>

            <div class="col0">

                <?php include('mini-calendar.php'); ?>


                <?php //include('share.php') ;?>

                <div class="clear"></div>

            </div>

            <div class="col1">
                <div class="switch-weeks" id="show-dates">Visa kalender</div>
                <div class="switch-weeks" id="hide-dates">Göm kalender</div>

                <?php
                    global $aveny;
                    $eventid = '';
                    if(isset($wp_query->query_vars['no'])) {
        				$eventid = urldecode($wp_query->query_vars['no']);
        				$event = $aveny->get_event($eventid);

                        print ('<div class="calendar-item pie">');
                            printf ('<h1>%s %s - %s</h1>',strftime("%A %e %h",strtotime($event['frandatum'])), $event['frantid'], $event['tilltid']);
                            printf ('<strong>%s</strong>', $event['titel']);
                            printf ('<em>%s</em>', $event['plats_namn']);
                            printf ('%s', $event['notering']);
                        print ('</div>');

                    } else {
        				print ('<div class="calendar-item pie">');
                            print ('<h1>Ingen kalenderhändelse vald</h1>');
        				print ('</div>');
                    }
				?>

                <?php include('meta.php');?>

            </div>

            <?php get_sidebar(); ?>

            <?php get_footer(); ?>


