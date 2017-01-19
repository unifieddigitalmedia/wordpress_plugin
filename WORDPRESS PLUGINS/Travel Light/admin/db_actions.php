<?php


class db_actions

{
  

 
 public static function db_actions_ini()
  

  {
    

add_action( 'wp_ajax_filter_serviceactionfe', array( __CLASS__, 'filter_service_action' ) );
add_action( 'wp_ajax_nopriv_filter_serviceactionfe', array( __CLASS__, 'filter_service_action' ) );


add_action( 'wp_ajax_filter_placehldersactionfe', array( __CLASS__, 'filter_plcservice_action' ) );

add_action( 'wp_ajax_nopriv_filter_placehldersactionfe', array( __CLASS__, 'filter_plcservice_action' ) );


add_action( 'wp_ajax_filter_actionfilter', array( __CLASS__, 'filter_action' ) );
add_action( 'wp_ajax_nopriv_filter_actionfilter', array( __CLASS__, 'filter_action' ) );


add_action( 'wp_ajax_filter_actionfin', array( __CLASS__, 'filter_actionfin' ) );
add_action( 'wp_ajax_nopriv_filter_actionfin', array( __CLASS__, 'filter_actionfin' ) );


add_action( 'wp_ajax_chat_action',array( __CLASS__, 'chat_action' )  );
add_action( 'wp_ajax_nopriv_chat_action', array( __CLASS__, 'chat_action' ) );




add_action( 'wp_ajax_filter_plcbrd_action',array( __CLASS__, 'filter_plcbrd_action' )  );
add_action( 'wp_ajax_nopriv_filter_plcbrd_action', array( __CLASS__, 'filter_plcbrd_action' ) );


 }


function chat_action() {

ob_clean();

$r = get_option('siteurl').'/wp-content/plugins/DragonBayInn/includes/db_map.php?location='.$_REQUEST[typeofc]; 

$html .='  </br><div id="trpcfm" class"trpcfm" >   

<div class="row"> <div class="col-sm-12" ><h2> Your trip is  </h2></div> </div>

<div class="row"> <div class="col-sm-12" ><h2 id="trpcfmdst" class="trpcfmdst">   </h2></div> </div>

<div class="row"> <div class="col-sm-12" ><h2> Please use the token below when checking out  </h2></div> </div>

<div class="row"> <div class="col-sm-12" ><h2>   </h2></div> </div>
</br>
<div class="row"> <div class="col-sm-12" >


<div id="fourthrowdivM"  >

<iframe src="'. $r.'" width="100%"  scrolling="no" seamless="seamless" 
id="trpcfmmap" onload="myFunction()"></iframe>

</div> 


</div> </div>




</div>









';

   wp_reset_postdata();

   echo $html;

   wp_die();




}



function filter_actionfin() { 

ob_clean();

global $the_post;


foreach ( $_REQUEST[fin] as $value ) 

{


$args = array( 'posts_per_page' => -1 , 'post_type' => 'place_of_interest','place_of_interest_map' => $_REQUEST[typeofc],"s" => $value);

$newposts = get_posts( $args );

$s = get_post_meta( $newposts[0]->ID );

$image = has_post_thumbnail( $newposts[0]->ID ) ;


$image = (has_post_thumbnail( $newposts[0]->ID ) ) ?  wp_get_attachment_image_src( get_post_thumbnail_id( $newposts[0]->ID ), 'single-post-thumbnail' ) : '';


$imageurl  = ( empty($image) ) ? 'http://www.thecaribbeanessence.com/images/logo.png' : $image[0];

$newsrc = 'http://dragonbayinnjamaica.com/wp-content/plugins/DragonBayInn/images/ic_star_border_black_24dp_1x.png';

$html .= '<div  class"findiv" >';

$html .= ' <div class="row"  id="fourthrowdivR">

<div class="col-sm-3" id="brandlogocont">

<img src="'.$imageurl.'" id="brandlogo"/> 

</div>
    <div class="col-sm-5" id="middlecol"> <div class="row" style="padding:10px;"> <div class="col-sm-12" >'.$value.'</div> </div>

<div class="row" style="padding:10px;"> <div class="col-sm-12" >'.$value.'</div> </div>

<div class="row" style="padding:10px;">

<div class="col-sm-12" >

<a href="#" title="'.$s[phone][0].'">Tel</a>&nbsp;&nbsp;<a href="mailto:'.$s[email][0].'" title="'.$s[email][0].'">Email</a>&nbsp;&nbsp;<a href="'.$s[website][0].'" title="'.$s[website][0].'">Website</a></div>
<div class="col-sm-4" ></div>
<div class="col-sm-4" ></div>

</div>


 </div>



    <div class="col-sm-4" >
    
    <div class="row">
    <div class="col-sm-12" id="endcol" ><img src="'.$newsrc.'" /><img src="'.$newsrc.'" /><img src="'.$newsrc.'" /><img src="'.$newsrc.'" /><img src="'.$newsrc.'" /></br>
<a href="'. esc_url( get_permalink($newposts[0]->ID ) ).'">Leave a comment</a></div>
    </div>

  </div>
  </div>' ;



}



wp_reset_postdata();

echo $html;

wp_die();



}

function filter_plcbrd_action() { 

   ob_clean();

$htmls = array();

   global $post;

$args = array( 'posts_per_page' => -1 , 'post_type' => 'place_of_interest','place_of_interest_map' => $_REQUEST[typeofc]);

$myposts = get_posts( $args );

foreach ( $myposts as $post ) : setup_postdata( $post ); 

$s = get_post_meta( $post->ID );

$image = has_post_thumbnail( $post->ID ) ;

$image = (has_post_thumbnail( $post->ID ) ) ?  wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ) : '';

$imageurl  = ( empty($image) ) ? 'http://www.thecaribbeanessence.com/images/logo.png' : $image[0];

$term_list = wp_get_post_terms($post->ID, 'place_of_interest_service', array("fields" => "all"));

$tax = $term_list[0]->name;

$tag = get_the_title($post->ID);

if(get_the_title($post->ID) === $_REQUEST[typeofb]) 

{

$html = array(

"fullname" => $s[fullname][0],
"company" => $s[company][0],
"phone" => $s[phone][0],
"email" => $s[email][0],
"website" => $s[website][0],
"latlng" => $s[latlng][0],
"country" => $s[country][0],
"address" => $s[address][0],
"typeofbusiness" => $s[typeofbusiness][0],
"service" => $tax,
"image"=>$imageurl,

);

array_push($htmls,$html);

}

   endforeach; 
   
   wp_reset_postdata();

   echo json_encode($htmls);

   wp_die();


}

function filter_plcservice_action() { 

   ob_clean();


$htmls = array();



foreach ( $_REQUEST[typeofs] as $value ) 

{



$args = array( 'posts_per_page' => -1 , 'post_type' => 'place_of_interest','place_of_interest_map' => $_REQUEST[typeofc]);

$myposts = get_posts( $args );

foreach ( $myposts as $post ) : setup_postdata( $post ); 

$s = get_post_meta( $post->ID );

$image = has_post_thumbnail( $post->ID ) ;

$image = (has_post_thumbnail( $post->ID ) ) ?  wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ) : '';

$imageurl  = ( empty($image) ) ? 'http://www.thecaribbeanessence.com/images/logo.png' : $image[0];

$term_list = wp_get_post_terms($post->ID, 'place_of_interest_business', array("fields" => "all"));

$businessname = $term_list[0]->name;

if($businessname == "Accomodation")
{

$iconurl = 'http://www.dragonbayinnjamaica.com/wp-content/plugins/DragonBayInn/assets/ic_hotel_black_48dp_1x.png';

}
else if($businessname == "Aesthetics and Therapy")
{
$iconurl = 'http://www.dragonbayinnjamaica.com/wp-content/plugins/DragonBayInn/assets/ic_beach_access_black_48dp_1x.png';

}
else if($businessname == "Arts and Culture")
{
$iconurl = 'http://www.dragonbayinnjamaica.com/wp-content/plugins/DragonBayInn/assets/ic_collections_black_48dp_1x.png';

}
else if($businessname == "Beaches")
{
$iconurl = 'http://www.dragonbayinnjamaica.com/wp-content/plugins/DragonBayInn/assets/ic_beach_access_black_48dp_1x.png';

}
else if($businessname == "Entertainment and Nightlife")
{
$iconurl = 'http://www.dragonbayinnjamaica.com/wp-content/plugins/DragonBayInn/assets/ic_speaker_black_48dp_1x.png';

}
else if($businessname == "Events")
{
$iconurl = 'http://www.dragonbayinnjamaica.com/wp-content/plugins/DragonBayInn/assets/ic_event_seat_black_48dp_1x.png';

}
else if($businessname == "Fashion")
{
$iconurl = 'http://www.dragonbayinnjamaica.com/wp-content/plugins/DragonBayInn/assets/ic_style_black_48dp_1x.png';

}
else if($businessname == "Food and Drink")
{
$iconurl = 'http://www.dragonbayinnjamaica.com/wp-content/plugins/DragonBayInn/assets/ic_local_dining_black_48dp_1x.png';

}
else if($businessname == "Leisure Activity")
{
$iconurl = 'http://www.dragonbayinnjamaica.com/wp-content/plugins/DragonBayInn/assets/ic_local_activity_black_48dp_1x.png';

}
else if($businessname == "Music")
{
$iconurl = 'http://www.dragonbayinnjamaica.com/wp-content/plugins/DragonBayInn/assets/ic_headset_black_48dp_1x.png';

}
else if($businessname == "Shop")
{
$iconurl = 'http://www.dragonbayinnjamaica.com/wp-content/plugins/DragonBayInn/assets/ic_shopping_basket_black_48dp_1x.png';

}



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
"company" =>$s[company][0],
"phone" => $s[phone][0],
"email" => $s[email][0],
"website" => $s[website][0],
"latlng" => $s[latlng][0],
"country" => $s[country][0],
"address" => $s[address][0],
"typeofbusiness" => $s[typeofbusiness][0],
"service" => $value,
"image"=>$imageurl,
"icon"=>$iconurl,
"Latitude" => str_replace(' ', '',$a[0]),
"Longitude" => str_replace(' ', '',$a[1]),


);

array_push($htmls,$html);

}


endforeach; 


}


   wp_reset_postdata();

   echo json_encode($htmls);

   wp_die();



}

function filter_action() { 

    ob_clean();

    global $post;

   /* 

    function last_thirty_days( $where = '' ) {

    global $wpdb;
 
    $where .= $wpdb->prepare( " AND post_title LIKE '%$_REQUEST[typeofb]%'" );
 
    return $where;

    }
 
    add_filter( 'posts_where', 'last_thirty_days' );

    remove_filter( 'posts_where', 'last_thirty_days' );*/
 
    $args = array( 'posts_per_page' => -1 , 'post_type' => 'place_of_interest','place_of_interest_map' =>   $_REQUEST[typeofc],'suppress_filters' =>false);

    $myposts = get_posts( $args );

    foreach ( $myposts as $post ) : setup_postdata( $post ); 

    $html .= '<div class="row"><div class="col-sm-12" id="placetag">'.get_the_title($post->ID).'</div></div>';
    endforeach; 

    wp_reset_postdata();

    echo $html;
    
    wp_die();


}

function filter_service_action() { 

    ob_clean();

$args = array( 'hide_empty' => false,'orderby'=> 'term_taxonomy_id','order'=> 'ASC');

$terms = get_terms('place_of_interest_service',$args);


foreach ($_REQUEST[typeofb] as $dbbis)

{

foreach ($terms as $term)

{

$db_ser_option = get_option( "taxonomy_".$term->term_id );

if($db_ser_option[tax_image] === $dbbis)

{


$html .= '
  <div class="row">
  <div class="col-sm-8">'.$term->name .'</div>
  <div class="col-sm-4" id="call-back_bis" ><input value="'.$term->name.'"type="checkbox" class="dbserchk" ></div>
  </div>';



}


}


}


   wp_reset_postdata();

   echo $html;

   wp_die();




}



}






?>