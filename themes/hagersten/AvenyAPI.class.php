<?php
class AvenyAPI {
	private $data;
	/*private $path = "https://aveny-hagersten.svenskakyrkan.se/WebAveny/avenyframsidan/?page=xml_aktiviteter";*/
	//private $path = "https://aveny-hagersten.svenskakyrkan.se/WebAveny_Hagersten/avenyframsidan/?page=xml_aktiviteter";
	private $path = "https://aveny-hagersten.svenskakyrkan.se/WebAveny_Hagersten/WebAveny_ISAPI.dll/AvenyFramsidan/Aveny_H%C3%A4gersten/xml_kalender";
	private $args;
	private $query;
	private $startDate;
	private $endDate;
	private $mysqli;
	private $events = array();
	// private $db_table = 'new_table';

	private $db_user = 'hagersten_master';
	private $db_passwd = '+{]KW-u(b5KV';
	private $db_database = 'hagersten_live';
	private $db_table = 'aveny_cache';
	private $db_host = 'localhost';
	
	//private $db_user = 'root';
	//private $db_passwd = '';
	//private $db_database = 'hagersten2';
	//private $db_table = 'aveny_cache';
	//private $db_host = 'localhost';

   //  else {
   //     private $db_user = 'hagersten_org';
   //     private $db_passwd = 'blbgOAI24C5MSQbjn42Q';
   //     private $db_database = 'hagersten_20150413';
   //     private $db_table = 'aveny_cache';
   //     private $db_host = 'localhost';
   // }


	public function __construct( $args = array() ) {
		$this->args = $args;

		if ( strstr( $_SERVER['HTTP_HOST'], 'dev.www.hagersten.org' ) ) {
			$this->db_user = "root";
			$this->db_passwd = "root123!";
			$this->db_database = "hagersten";
			$this->db_table = 'aveny_cache';
		}
		
		if ( strstr( exec('hostname'), 'stokmedia.eu' ) ) {
			$this->db_user = "stokmedi_stage";
			$this->db_passwd = "[wfGd}p-{MHM";
			$this->db_database = "stokmedi_hagersten";
			$this->db_table = 'aveny_cache';
		}

		// $this->mysqli = new mysqli("127.0.0.1", "aveny_kal", "aveny_kal", "aveny_kal");

		//var_dump( $this->db_host, $this->db_user, $this->db_passwd, $this->db_database );

		$this->mysqli = new mysqli( $this->db_host, $this->db_user, $this->db_passwd, $this->db_database );

		if ( $this->mysqli->connect_errno ) {
			echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
		}

		$query = "";
		$count = 0;
		foreach ( $this->args as $key => $value ) {
			$prefix = ( $count == 0 ) ? '?' : '&';
			$query .= $prefix . $key . '=' . $value;
			$count++;
		}
		$this->query = $query;
	} //__construct()

	public function curl() {
		// INITIATE CURL.
		$curl = curl_init();

		// CURL SETTINGS.
		curl_setopt( $curl, CURLOPT_URL, $this->path.$this->query );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 0 );
		curl_setopt( $curl, CURLOPT_ENCODING, 'UTF-8' );

		// GRAB THE XML FILE.
		$this->data = curl_exec( $curl );
		curl_close( $curl );
	} //curl()

	public function save() {
		$this->curl();
		$xml = new SimpleXMLElement( $this->data );

		print( '<br>' );
		echo "<pre>";
		echo "Crawled following xml path: ".$this->path.$this->query."<br/>";
		echo "Saving ".count( $xml->aktivitet ). " entries";
		echo "</pre>";
		print '<hr/>';

		// Error counting variable
		$failed_entries = 0;

		// if we have a date set from which and forward we'll be getting events, remove only previous events from that date and forward , not older ones
		if ( $this->args['DateFrom'] ) {
			$this->mysqli->query( "DELETE FROM $this->db_table WHERE frandatum>='".$this->args['DateFrom']."'" );
			print "Removed Some posts from db";
		}
		// Otherwise, wipe it all
		else {
			// Clear old posts
			$this->mysqli->query( "TRUNCATE TABLE $this->db_table" );
			print "Removed All posts from db";
		}
		
		foreach ( $xml->aktivitet as $akt ) {
			$frandatum = $akt->datum;
			$tilldatum = $akt->datum;
			$time = explode( '-', $akt->tid );
			$frantid = trim( $time[0] );
			$tilltid = trim( $time[1] );
			$titel = $akt->titel;
			$kategori = $akt->kategori;
			$notering = $akt->notering;
			$plats_id = $akt->resursid_1;
			$plats_namn = $akt->resurs_1;
	

			// Insert new/modified posts
			$query = "INSERT INTO $this->db_table (
				frandatum,
				tilldatum,
				frantid,
				tilltid,
				titel,
				kategori,
				notering,
				plats_id,
				plats_namn
				) VALUES (
				'$frandatum',
				'$tilldatum',
				'$frantid',
				'$tilltid',
				'$titel',
				'$kategori',
				'$notering',
				'$plats_id',
				'$plats_namn'
				)";
			
			try{
				$this->mysqli->query( $query );
				print_r( $titel );
			}
			catch( Exception $e ) {
				$failed_entries ++ ;
				print "Error - ".$e->getMessage()."<br/>";
			}

		}// foreach
		
		echo "Failed entries: " . $failed_entries."<br/>";
		echo "Saved";
	} //save()

	function get_event_dates() {
		$query = "select distinct frandatum from $this->db_table";

		$result = $this->mysqli->query( $query );
		if ( $result->num_rows > 0 ) {
			while ( $row = $result->fetch_array( MYSQLI_ASSOC ) ) $data[] = $row['frandatum'];
		} else {
			$data = null;
		}
		return $data;
	}

	/* Takes a date and retuns an array of formatted datestrings, a week forward from that */
	function week_dates( $date = null, $format = null, $start = 'monday' ) {
		// is date given? if not, use current time...
		if ( is_null( $date ) ) $date = date( "Y-m-d" );

		// Get milliseconds of the selected date, to count with/on
		$msec = strtotime( $date );

		// get the timestamp of the day that started $date's week...
		$weekstart = $msec - ( 86400 * ( date( 'N', $msec )-1 ) );

		// add 86400 to the timestamp for each day that follows it...
		for ( $i = 0; $i < 7; $i++ ) {
			$day = $weekstart + ( 86400 * $i );
			if ( is_null( $format ) ) $dates[$i] = $day;
			else $dates[$i] = date( $format, $day );
		}

		return $dates;
	}

	public function get_by_location( $args ) {
		$query = ( "SELECT * FROM $this->db_table" );
		$return = array();
		if ( is_array( $args ) && sizeof( $args ) > 0 ) {

			$action = "";

			// if (isset($args['location']) || isset($args['category'])) {
			$query .= " WHERE";
			// }

			if ( isset( $args['location'] ) ) {
				if ( is_array( $args['location'] ) && sizeof( $args['location'] ) > 0 ) {
					$query .= $action . " plats_id IN ('".implode( "', '", $args['location'] )."')";
					$action = " AND";
				} else {
					$query .= $action . " plats_id = '".$args['location']."'";
					$action = " AND";
				}

			}

			if ( isset( $args['category'] ) ) {


				if ( is_array( $args['category'] ) && sizeof( $args['category'] ) > 0 ) {
					$query .= $action . " kategori IN ('".implode( "', '", $args['category'] )."')";
					$action = " AND";
				} else {
					$query .= $action . " kategori = '".$args['category']."'";
					$action = " AND";
				}

			}
			$query .= $action." frandatum >= '".date( "Y-m-d" )."'";
			$query .= ' ORDER BY frandatum ASC';

			if ( isset( $args['limit'] ) ) {
				$query .= ' LIMIT '.$args['limit'];
			}


			$result = $this->mysqli->query( $query );
			print ( $this->mysqli->error );

			while ( $row = $result->fetch_array( MYSQLI_ASSOC ) ) {
				$return[] = $row;
			}
		}
		return $return;
	}


	/**
	 * Enter description here ...
	 *
	 * @param unknown_type $weekno
	 * Returns null on no result.
	 * Test for !is_null().
	 */
	public function get_week( $date = null /* should be date */ ) {
		if ( is_null( $date ) ) {
			$date = date( "Y-m-d" );
		} /*elseif (preg_match("/^\d{4}\-\d{1,2}\-\d{1,2}/", $weekno)) {

		}*/

		$dates = $this->week_dates( $date, "Y-m-d" );
		foreach ( $dates as $date ) {
			$data[$date] = $this->get_day( $date );
		}
		return $data;
	}
	public function get_day( $date ) {
		$query = "SELECT * FROM {$this->db_table} WHERE frandatum = '$date' ORDER BY frandatum";
		$result = $this->mysqli->query( $query );

		if ( $result->num_rows > 0 ) {
			while ( $row = $result->fetch_array( MYSQLI_ASSOC ) ) $data[] = $row;
		} else {
			$data = null;
		}
		return $data;
	} //get_day()

	public function get_event( $eventid ) {
		$query = "SELECT * FROM {$this->db_table} WHERE id = $eventid";
		// echo $query;
		return $this->mysqli->query( "SELECT * FROM {$this->db_table} WHERE id = $eventid" )->fetch_array( MYSQLI_ASSOC );

	} //get_event()

	/**
	 * $args = array (
	 *   'location' =>
	 *   'category' =>
	 *   'limit' =>
	 *   'startdate' =>
	 *
	 * );
	 * Enter description here ...
	 *
	 * @param unknown_type $args
	 */


	public function get_events( $args = array() ) {
		$query = ( "SELECT * FROM $this->db_table" );
		if ( is_array( $args ) && sizeof( $args ) > 0 ) {

			$action = "";
			$query .= " WHERE";

			if ( isset( $args['location'] ) ) {
				if ( is_array( $args['location'] ) && sizeof( $args['location'] ) > 0 ) {
					$query .= $action . " plats_id IN ('".implode( "', '", $args['location'] )."')";
					$action = " AND";
				} else {
					$query .= $action . " plats_id = '".$args['location']."'";
					$action = " AND";
				}

			}

			if ( isset( $args['category'] ) ) {
				//$args['category'] = str_replace(array('ä', 'ö'), array('Ã¤', 'Ã–'), $args['category']);
				$args['category'] = ucwords($args['category']);
				if ( is_array( $args['category'] ) && sizeof( $args['category'] ) > 0 ) {
					$query .= $action . " kategori IN ('".implode( "', '", $args['category'] )."')";
					$action = " AND";
				} else {
					$query .= $action . " kategori = '".$args['category']."'";
					$action = " AND";
				}

			}
			$query .= $action." frandatum >= '".date( "Y-m-d" )."'";
			$query .= ' ORDER BY frandatum ASC';

			if ( isset( $args['limit'] ) ) {
				$query .= ' LIMIT '.$args['limit'];
			}

			$result = $this->mysqli->query( 'set names latin1' );
			$result = $this->mysqli->query( $query );

			print ( $this->mysqli->error );


			while ( $row = $result->fetch_array( MYSQLI_ASSOC ) ) {
				$return[] = $row;
			}

		}

		return $return;
	} //get_events()

	public function display() {

		$result = $this->mysqli->query( "SELECT * FROM $this->db_table" );

		/* fetch values */
		while ( $row = $result->fetch_array( MYSQLI_ASSOC ) ) {
			print( '<br>' );
			echo "<pre>";
			var_dump( $row );
			echo "</pre>";
			print '<hr/>';
		}


	} //display()

} //AvenyAPI
