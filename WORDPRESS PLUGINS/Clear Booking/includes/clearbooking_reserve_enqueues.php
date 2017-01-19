<?php

if ( ! defined( 'ABSPATH' ) ) exit;
 
class clearbooking_reserve_enqueues

{
  




public static function clearbooking_reserve_enqueues_admin()
  

{
    
    wp_enqueue_script('clear-booking-admin',plugins_url( 'clearbooking_reserve_js_script.js', __FILE__ ),array( 'jquery', 'jquery-ui-core','jquery-ui-datepicker' )  ,false, true ); 



    
    wp_localize_script( 'main_ajax', 'ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ),false,false,false );

    
    wp_enqueue_style( 'clear-booking-admin',plugins_url( 'index_admin.css', __FILE__ ) );
   
 






}



public static function clearbooking_reserve_enqueues_() 



{



    wp_enqueue_style( 'clear-booking-frontend', plugins_url( 'index.css', __FILE__ ));
   
 
   wp_enqueue_script('clear-booking-frontend', plugins_url( 'clearbooking_reserve_js_script.js', __FILE__ ),array('jquery','jquery-ui-core') ,'1.0.0', true ); 

 
   wp_localize_script( 'clear-booking-frontend', 'ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ),false,false,false );


   wp_register_style('boot_css',plugins_url( 'bootstrap.min.css', __FILE__ ));

   wp_enqueue_style('boot_css'); 
 
   wp_register_script('boot_js',plugins_url( 'bootstrap.min.js', __FILE__ ),array( 'jquery', 'jquery-ui-core' ) );

   wp_enqueue_script('boot_js'); 


  





  




 

}




}

 
?>