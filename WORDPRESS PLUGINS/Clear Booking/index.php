<?php



    /*
      /*
    Plugin Name: Clear Booking
    Plugin URI: https://clear-booking.herokuapp.com
    Description: Plugin for displaying places of interest
    Author: M. Slack
    Version: 1.0
    Author URI: http://unifieddigitalmedia.herokuapp.com

   Clear Booking is free software: you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation, either version 2 of the License, or
   any later version.
 
   TClear Booking is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
   GNU General Public License for more details.
 
   You should have received a copy of the GNU General Public License
   along with Clear Booking. If not, see http://www.gnu.org/licenses/gpl-2.0.html.

   */


defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );



spl_autoload_register(function ($class) {



if (file_exists(dirname( __FILE__ ) . '/admin/'. $class .'.php')) {


include dirname( __FILE__ ) . '/admin/'. $class .'.php';

}

else 

{


include dirname( __FILE__ ) . '/includes/'. $class .'.php';


}




});


if ( is_admin() ) {


  
  register_activation_hook( __FILE__, 'clearbooking_reserveDatabaseInstall::clearbookings_rooms_create' );

  register_activation_hook( __FILE__, 'clearbooking_reserveDatabaseInstall::clearbookings_create_coupons_table' );

  register_activation_hook( __FILE__, 'clearbooking_reserveDatabaseInstall::clearbookings_create_bookings_table' );

  register_activation_hook( __FILE__, 'clearbooking_reserveDatabaseInstall::clearbookings_create_reservation_table' );

  register_activation_hook( __FILE__, 'clearbooking_reserveDatabaseInstall::clearbookings_create_reservation_coupons_table' );

  register_activation_hook( __FILE__, 'clearbooking_reserveDatabaseInstall::clearbookings_create_addons_table' );

  register_activation_hook( __FILE__, 'clearbooking_reserveDatabaseInstall::clearbookings_create_reservation_addons_table' );


  add_action( 'init', 'clearbooking_reserve_custom_posts::clearbooking_reserve_custom_posts_rooms_create' );

  add_action( 'init', 'clearbooking_reserve_custom_posts::clearbooking_reserve_custom_posts_coupons_create' );

  add_action( 'init', 'clearbooking_reserve_custom_posts::clearbooking_reserve_custom_posts_categories_create' );

  add_action( 'init', 'clearbooking_reserve_custom_posts::clearbooking_reserve_custom_posts_add_ons_create' );

  
  

  add_action( 'add_meta_boxes','clearbooking_reserve_custom_posts_meta::clearbooking_reserve_custom_posts_meta_' );

  add_action('save_post', 'clearbooking_reserve_custom_posts_meta::clearbooking_reserve_custom_posts_meta_save', 10, 2 );

  add_action('admin_menu', 'clearbooking_reserve_menu_items::clearbooking_reserve_menu_items_create');



  add_action( 'admin_enqueue_scripts', 'clearbooking_reserve_enqueues::clearbooking_reserve_enqueues_admin');



  add_action( 'wp_ajax_bkng', 'clearbooking_reserve_actions::rooms_action_booking' ) ;
  add_action( 'wp_ajax_nopriv_bkng', 'clearbooking_reserve_actions::rooms_action_booking' ) ;


  add_action( 'wp_ajax_loadcal', 'clearbooking_reserve_actions::load_cal' ) ;
  add_action( 'wp_ajax_nopriv_loadcal', 'clearbooking_reserve_actions::load_cal' ) ;


  add_action( 'wp_ajax_loadcalto', 'clearbooking_reserve_actions::load_to_cal' ) ;
  add_action( 'wp_ajax_nopriv_loadcalto', 'clearbooking_reserve_actions::load_to_cal' ) ;


  add_action( 'wp_ajax_offers', 'clearbooking_reserve_actions::offers_action' ) ;
  add_action( 'wp_ajax_nopriv_offers', 'clearbooking_reserve_actions::offers_action' ) ;


  add_action( 'wp_ajax_resdetails', 'clearbooking_reserve_actions::resdetails' ) ;
  add_action( 'wp_ajax_nopriv_resdetails', 'clearbooking_reserve_actions::resdetails' ) ;


  add_action( 'wp_ajax_reservationdetails', 'clearbooking_reserve_actions::reservationdetails' ) ;
  add_action( 'wp_ajax_nopriv_reservationdetails', 'clearbooking_reserve_actions::reservationdetails' ) ;


  add_action( 'wp_ajax_rooms', 'clearbooking_reserve_actions::rooms_action' ) ;
  add_action( 'wp_ajax_nopriv_rooms', 'clearbooking_reserve_actions::rooms_action' ) ;


  add_action( 'wp_ajax_bkngtlt', 'clearbooking_reserve_actions::total_action' ) ;
  add_action( 'wp_ajax_nopriv_bkngtlt', 'clearbooking_reserve_actions::total_action' ) ;



} else {


 add_action('wp_enqueue_scripts', 'clearbooking_reserve_enqueues::clearbooking_reserve_enqueues_'); 

 add_shortcode('clearbooking_calendar', 'clearbooking_reserve_shortcodes::clearbooking_reserve_shortcode');

 add_filter('the_content', 'clearbooking_reserve_filters::clearbooking_reservation_details_');  

 add_action('wp_head', 'clearbooking_confirmation_mail::clearbooking_confirmation_mail_');


}



?>