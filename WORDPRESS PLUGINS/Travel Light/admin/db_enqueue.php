<?php
 
class db_enqueue
{
  

 public static function db_enq_ini()
  

  {
    


   add_action('admin_enqueue_scripts',array( 'db_enqueue', 'db_enqueue_functions' ));


  }


 public static function db_enq_ini_fe()
  

  {
    


add_action('wp_enqueue_scripts', array( __CLASS__, 'db_enqueue_functions_fe' ));



  }




  public static function db_enqueue_functions_fe() {




  wp_register_style('jqcss','http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css',false,false,false); 

  wp_enqueue_style('jqcss'); 



  wp_register_script('jq_js','http://code.jquery.com/jquery-1.10.2.js',false,false,false); 

  wp_enqueue_script('jq_js'); 


  wp_register_script('jqs_js','http://code.jquery.com/ui/1.11.4/jquery-ui.js',false,false,false );

  wp_enqueue_script('jqs_js'); 



  wp_register_script('main_js',plugins_url( 'DragonBayInn/js/feindex.js' ),array( 'jquery' ),'1.0.0', false ); 

  wp_enqueue_script('main_js'); 




  wp_localize_script( 'main_js', 'ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ),false,false,false );

  wp_register_style('main_css',plugins_url( 'DragonBayInn/css/feindex.css' ) );
 
  wp_enqueue_style('main_css'); 


 wp_register_style('boot_css','http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css' ,false,false,false);

 wp_enqueue_style('boot_css'); 


wp_register_script('boot_js','http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js' ,false,false,false);

wp_enqueue_script('boot_js'); 


wp_register_script('boot_js1','https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js' ,false,false,false);

wp_enqueue_script('boot_js1'); 




}


public static function db_enqueue_functions() {

$d = plugins_url( 'DragonBayInn/js/index.js' );


wp_register_script('main_js',plugins_url( 'DragonBayInn/js/index.js' ),array( 'jquery' ),'1.0.0', true ); 

wp_enqueue_script('main_js'); 

wp_enqueue_style( wp_register_style('main_css',plugins_url( 'DragonBayInn/css/index.css' ) )); 

wp_localize_script( 'main_js', 'ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

$url = esc_attr( get_option('db_goggle_key'));


$url = "https://maps.googleapis.com/maps/api/js?key=".$url."&sensor=true";

wp_register_script('googlemap',$url);

wp_enqueue_script('googlemap'); 

wp_register_script('googlemap1','https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false');

wp_enqueue_script('googlemap1'); 



}




}

 
?>