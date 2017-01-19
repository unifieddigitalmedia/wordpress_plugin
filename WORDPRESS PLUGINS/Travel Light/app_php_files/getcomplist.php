<?php



   header("Access-Control-Allow-Origin: *");

   header("Content-Type: application/json; charset=UTF-8");

   $path = $_SERVER['DOCUMENT_ROOT'];

   include_once $path . '/wp-config.php';

   include_once $path . '/wp-load.php';

   include_once $path . '/wp-includes/wp-db.php';

   include_once $path . '/wp-includes/pluggable.php';


$htmls = array();

foreach ( $_REQUEST[service] as $value ) 

{

$args = array( 'posts_per_page' => -1 , 'post_type' => 'place_of_interest','place_of_interest_map' => $_REQUEST[country]);

$myposts = get_posts( $args );

foreach ( $myposts as $post ) : setup_postdata( $post ); 

$s = get_post_meta( $post->ID );

$image = has_post_thumbnail( $post->ID ) ;

$image = (has_post_thumbnail( $post->ID ) ) ?  wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ) : '';

$imageurl  = ( empty($image) ) ? 'http://www.thecaribbeanessence.com/images/logo.png' : $image[0];

$term_list = wp_get_post_terms($post->ID, 'place_of_interest_service', array("fields" => "all"));

$tax = $term_list[0]->name;

if($tax === $value) 

{

$name = str_replace("'", "", $s[company][0]);

$name2 = str_replace("'", "",$s[company][0]);

$latlng = str_replace('(','',$s[latlng][0]);

$latlng = str_replace(')','', $latlng);

$a = array();

$a = explode(",",$latlng);

$html = array(

"fullname" => $s[fullname][0],
"company" => $s[company][0],
"phone" => $s[phone][0],
"email" => $s[email][0],
"website" => $s[website][0],
"latlng" => $s[latlng][0],
"country" => $s[country][0],
"description" => $s[description][0],
"address" => $s[address][0],
"typeofbusiness" => $s[typeofbusiness][0],
"service" => $value,
"image"=>$imageurl,
"Latitude" => str_replace(' ', '',$a[0]),
"Longitude" => str_replace(' ', '',$a[1]),
"asd" => $a,
);

array_push($htmls,$html);

}

endforeach; 

}

$tmp = array();

foreach($htmls as $k => $v)

{

   
 $tmp[$k] = $v[company];


}

$tmp = array_unique($tmp);

foreach($htmls as $k => $v)

{


    if (!array_key_exists($k, $tmp))

        unset($htmls[$k]);

}

echo json_encode(array_values($htmls));






?>