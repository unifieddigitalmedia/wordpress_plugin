<?php



   header("Access-Control-Allow-Origin: *");

   header("Content-Type: application/json; charset=UTF-8");

   $path = $_SERVER['DOCUMENT_ROOT'];

   include_once $path . '/wp-config.php';

   include_once $path . '/wp-load.php';

   include_once $path . '/wp-includes/wp-db.php';

   include_once $path . '/wp-includes/pluggable.php';


$args = array( 'hide_empty' => false,'orderby'=> 'name','order'=> 'ASC');

$terms = get_terms('place_of_interest_business',$args);


$contain = array();

$container = array();

foreach ($terms as $term)

{




array_push($contain,$term->name);





}

array_push($container,$contain);

$contain = array();

if(!empty($_REQUEST[business]))

{


$args = array( 'hide_empty' => false,'orderby'=> 'term_taxonomy_id','order'=> 'ASC');

$terms = get_terms('place_of_interest_service',$args);



foreach ($_REQUEST[business] as $business_type)

{



foreach ($terms as $term)

{


$db_ser_option = get_option( "taxonomy_".$term->term_id );


if($db_ser_option[tax_image] === $business_type)

{

array_push($contain,$term->name);


}


}





}

array_push($container,$contain);

}

echo json_encode($container);




?>