<?php



class db_database


{


public static function db_database_()


  {


       register_activation_hook( __FILE__, array( __CLASS__, 'db_trip_create' )  );



  }

public static function db_trip_create()


  {


   	global $wpdb;

	global $jal_db_version;

        $jal_db_version = '1.0';

	$table_name = $wpdb->prefix . 'db_trip';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
	
         tid mediumint(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	
         place varchar(100) NOT NULL,
      
         token text(100) NOT NULL,

         distance decimal(10,2) NOT NULL,

         resid mediumint(100) NOT NULL,

	 UNIQUE KEY tid (tid)

	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );

  }





}


?>