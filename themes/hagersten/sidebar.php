
<?php
$catCaptions = array (
	'gudstjänst' => 'Gudstjänster',
	'konsert' => 'Konserter',
	'övrigt' => 'Övrigt'
);

/*
Correct but buggy implementation.
Cant use registered query_var for index.php
if(isset($wp_query->query_vars['kat'])) {
	$currentSidebarHeading = $catCaptions[urldecode($wp_query->query_vars['kat'])];
} else {
	$currentSidebarHeading = "Alla kategorier";
}

*/
if(isset($_GET['kat'])) {
	$currentSidebarHeading = $catCaptions[$_GET['kat']];
} else {
	$currentSidebarHeading = "Alla kategorier";
}

global $aveny;

?>
				<aside class="col2" id="sidebar">

				<?php include_once('socialMedia.php'); ?>
                    <?php include_once('mini-calendar.php'); ?>

                    <div class="calendar-select pie">
						Kalender: <span><?php print($currentSidebarHeading);?></span>
						<span class="drop-down"></span>
					</div>
					<ul class="calendar-drop-down pie">
						<li><a href="<?php echo remove_query_arg( 'kat');?>">Alla kategorier</a></li>
						<li><a href="<?php echo add_query_arg( 'kat', 'gudstjänst');?>"><?php print($catCaptions['gudstjänst']);?></a></li>
						<li><a href="<?php echo add_query_arg( 'kat', 'konsert');?>"><?php print($catCaptions['konsert']);?></a></li>
						<li><a href="<?php echo add_query_arg( 'kat', 'övrigt');?>"><?php print($catCaptions['övrigt']);?></a></li>
						<?php /*
						<li><a href="#">Alla kategorier</a></li>
						<li><a href="?kat=gudstjänst">Gudstjänster</a></li>
						<li><a href="?kat=konsert">Konserter</a></li>
						<li><a href="?kat=övrigt">Övrigt</a></li>
					*/ ?>
						</ul>

					<?php
//					$aveny = new AvenyAPI();
global $aveny;
//var_dump($aveny);
					$limit = 10;
					if(is_front_page()) {
						$limit = 6;
					}

					if (isset($_GET['kat'])) {
						$events = $aveny->get_events(array('limit'=>$limit, 'category'=>$_GET['kat']));
					} else {
						$events = $aveny->get_events(array('limit'=>$limit));
					}

					if( $events && is_array($events) && count($events) > 0)
					{
						
						foreach ($events as $event) {
		// var_dump($event);
							printf ('<div class="calendar-item pie" onclick="location.href=\'/kalender/handelse/?no=%s\'">', $event['id']);
							printf ('<a href="/kalender/handelse/?no=%s">%s kl. %s</a>', $event['id'], strftime("%A %e %h",strtotime($event['frandatum'])), $event['frantid']);
							printf ('<strong>%s</strong>', $event['titel']);
							print ('<em>');
							print ($event['plats_namn']);
							print ('</em>');
							printf ('<p>%s</p>',$event['notering']);
							print ('</div>');
						}
						?>
						<a href="/kalender" class="boxed-link pie">Fler kalenderhändelser</a>
						<?php
					}
					else {
						?>
						<em>Hittade inga händelser</em>
						<?php
					}
					?>






				</aside>
