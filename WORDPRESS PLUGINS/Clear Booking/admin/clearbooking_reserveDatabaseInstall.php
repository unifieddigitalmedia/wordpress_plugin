<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class clearbooking_reserveDatabaseInstall


{


public static function clearbookings_rooms_create()


  {


   	global $wpdb;

	global $jal_db_version;

        $jal_db_version = '1.0';

	$table_name = $wpdb->prefix . 'cb_rooms';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
	
         rid mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	
         name varchar(110) NOT NULL,
      
         description text(110) NOT NULL,
      
         occupancy int(9) NOT NULL,
      
         price decimal(10,2) NOT NULL,

         post_id mediumint(100) NOT NULL,

	 UNIQUE KEY rid (rid)

	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );

  }



public static function clearbookings_create_addons_table()


  {


   	global $wpdb;

	global $jal_db_version;

        $jal_db_version = '1.0';

	$table_name = $wpdb->prefix . 'cb_add_ons';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
	
         aid mediumint(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	
         name varchar(100) NOT NULL,
      
         description text(100) NOT NULL,

         frequency text(100) NOT NULL,

         price decimal(10,2) NOT NULL,

	 UNIQUE KEY aid (aid)

	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );

  }





public static function clearbookings_create_coupons_table()


  {


global $wpdb;

	global $jal_db_version;

        $jal_db_version = '1.0';

	$table_name = $wpdb->prefix . 'cb_coupons';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
	
         cid mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	
         name varchar(110) NOT NULL,
      
         description text(110) NOT NULL,
      
         amount decimal(10,2) NOT NULL,
      
         validdate date NOT NULL,

         exdate date NOT NULL,

         token varchar(11) NULL,

         post_id mediumint(100) NOT NULL,

	 UNIQUE KEY cid (cid)

	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );

   	
  }



public static function clearbookings_create_bookings_table()


  {


        global $wpdb;

	global $jal_db_version;

        $jal_db_version = '1.0';

	$table_name = $wpdb->prefix . 'cb_bookings';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
	
         bid mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,

         resid mediumint(9) NOT NULL ,

         rid mediumint(9)  NOT NULL,
	  
         status text NOT NULL,
      
         fromdate date NOT NULL,

         todate date NOT NULL,

         token varchar(11) NOT NULL,

	 UNIQUE KEY bid (bid)

	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );

   	
  }

public static function clearbookings_create_reservation_coupons_table()


  {


        global $wpdb;

	global $jal_db_version;

        $jal_db_version = '1.0';

	$table_name = $wpdb->prefix . 'cb_reservation_coupons';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
	
         crid mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,

         resid mediumint(9) NOT NULL ,

         cid mediumint(9)  NOT NULL,
	
	 UNIQUE KEY crid (crid)

	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );

   	
  }

public static function clearbookings_create_reservation_addons_table()


  {


        global $wpdb;

	global $jal_db_version;

        $jal_db_version = '1.0';

	$table_name = $wpdb->prefix . 'cb_reservation_add_ons';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
	
         raid mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,

         resid mediumint(9) NOT NULL ,

         aid mediumint(9)  NOT NULL,

         amount decimal(10,2) NOT NULL,
	
	 UNIQUE KEY raid (raid)

	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );

   	
  }



public static function clearbookings_create_reservation_table()


  {


        global $wpdb;

	global $jal_db_version;

        $jal_db_version = '1.0';

	$table_name = $wpdb->prefix . 'cb_reservations';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
	
         resid mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,

         fromdate date NOT NULL,

         todate date NOT NULL,

         dateheld datetime NOT NULL,

         lengthofstay int NOT NULL,

firstname varchar(110) NOT NULL,

lastname varchar(110) NOT NULL,

phone varchar(110) NOT NULL,

email varchar(110) NOT NULL,

idtype varchar(110) NOT NULL,

idnumber varchar(110) NOT NULL,

idexpiry date NOT NULL,

adults mediumint(9) NOT NULL ,

children mediumint(9) NOT NULL ,

infants mediumint(9) NOT NULL ,

datedepositheld date NOT NULL,

deadline date NOT NULL,

depositpaid decimal(10,2) NOT NULL,

balance decimal(10,2) NOT NULL,

roomtotal decimal(10,2) NOT NULL,

total decimal(10,2) NOT NULL,

discount decimal(10,2) NOT NULL,

addOnAmt decimal(10,2) NOT NULL,

tax decimal(10,2) NOT NULL,

tripcode varchar(110) NOT NULL,

paypaltoken varchar(110) NOT NULL,

devicetoken varchar(1000) NOT NULL,

checkintoken varchar(1000) NOT NULL,

pId varchar(110) NOT NULL,
	
	 UNIQUE KEY resid (resid)

	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );

   	
  }




}

?>