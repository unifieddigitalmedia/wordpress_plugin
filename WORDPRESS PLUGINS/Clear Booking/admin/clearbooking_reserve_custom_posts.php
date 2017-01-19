<?php


if ( ! defined( 'ABSPATH' ) ) exit;

class clearbooking_reserve_custom_posts


{


public static function clearbooking_reserve_custom_posts_rooms_create()


  {



register_post_type( 'clearbooking_rooms',
    array(
      'labels' => array(
        'name' => __( 'Rooms' ),
        'singular_name' => __( 'Room' ),
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'rooms'),
      'show_ui'=>true,
      'show_in_menu'=> __( 'cbreserve' ),
      'add_new' => 'Add new room',
      'add_new_item' => 'Add new room',
    )
  );

       
  }



public static function clearbooking_reserve_custom_posts_coupons_create()


  {

register_post_type( 'clearbooking_coupons',
    array(
      'labels' => array(
        'name' => __( 'Coupons' ),
        'singular_name' => __( 'Coupon' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'coupons'),
      'show_ui'=>true,
      'show_in_menu'=> __( 'cbreserve' ),
      'add_new' => 'Add new coupon',
      'add_new_item' => 'Add new coupon',
    )
  );

  }


public static function clearbooking_reserve_custom_posts_add_ons_create()


  {

register_post_type( 'clearbooking_add_ons',
    array(
      'labels' => array(
        'name' => __( 'Amenity' ),
        'singular_name' => __( 'Amenity' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'addons'),
      'show_ui'=>true,
      'show_in_menu'=> __( 'cbreserve' ),
      'add_new' => 'Add new amenity',
      'add_new_item' => 'Add new amenity',
    )
  );

  }







}


?>