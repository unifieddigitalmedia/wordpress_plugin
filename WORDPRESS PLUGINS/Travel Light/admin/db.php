<?php
 
class db
{
  





public static function autoload($class) {

        include $class . '.class.php';

    }

 public static function dbini()
  

  {
    

  add_action( 'init', array( 'db', 'dbtax' ) );

  add_action('save_post', array( 'db', 'db_post' ), 10, 2 );

  add_action( 'init', array( 'db', 'jal_install_admin' ) );

  add_action('admin_menu', array( 'db', 'db_plugin_menu' ));



  }
 public static function dbinife()
  

  {
    
 add_action( 'init', array( 'db', 'dbtax' ) );

  }


public static function db_plugin_menu() {


add_options_page('Dragon Bay Settings', 'Dragon Bay Settings', 'manage_options', 'my-plugin.php',array( 'db', 'db_settings_page' ));


}

function db_settings_page() {
?>
<div class="wrap">

<?php


 if ( isset( $_POST['db_goggle_key'] ) ) {
 

        update_option( "db_goggle_key", sanitize_text_field( $_POST['db_goggle_key']) );
 
    } 


?>
<h2>Dragon Bay Inn Settings</h2>

<form method="post" action="">
    <?php settings_fields( 'db-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'db-plugin-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Google API key</th>
        <td><input type="text" name="db_goggle_key" value="<?php echo esc_attr( get_option('db_goggle_key') ); ?>" /></td>
        </tr>
        <tr valign="top">
        <th scope="row">Website URL </th>
        <td><input type="text" name="siteurl" value="<?php echo esc_attr( get_option('siteurl') ); ?>" /></td>
        </tr>  
 
    </table>
    
    <?php submit_button(); ?>

</form>
</div>

<?php } 


  public static function dbtax()
  

  {
     

 register_post_type( 'place_of_interest',

        array(

                'labels' => array(
                'name' => 'Dragon Bay Inn',
                'singular_name' => 'Place Of Interest',
                'add_new' => 'Add New Place of Interest',
                'add_new_item' => 'Add New Place Of Interest',
                'edit' => 'Edit',
                'edit_item' => 'Edit Place Of Interest',
                'new_item' => 'New Place Of Interest',
                'view' => 'View',
                'view_item' => 'View Place Of Interest',
                'search_items' => 'Search Places Of Interest',
                'not_found' => 'No Place Of Interest found',
                'not_found_in_trash' => 'No Place Of Interest found in Trash',
                'parent' => 'Parent Place Of Interest'

            ),
 
            'public' => true,
            'hierarchical'=> true,
            'menu_position' => 15,'show_ui'=>true,
            'supports' => array( 'title', 'editor', 'thumbnail','comments','post-formats'),
            'taxonomies' => array('place_of_interest_map'),
            'menu_icon' => plugins_url( 'images/DB_FAV_ICON.png', __FILE__ ),	'capability_type' => 'page',
            'has_archive' => true,'rewrite'=> array('slug' => 'place_of_interest'),
        )
    );


    register_taxonomy(
        'place_of_interest_map',
        'place_of_interest',
        array(
            'labels' => array(
                'name' => 'Maps',
                'add_new_item' => 'Add New Place Of Interest Map',
                'new_item_name' => "New Map "
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
        )
    );


 register_taxonomy(
        'place_of_interest_business',
        'place_of_interest',
        array(
            'labels' => array(
                'name' => 'Business type',
                'add_new_item' => 'Add New Place Of Interest Map',
                'new_item_name' => "New Map "
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
        )
    );



 register_taxonomy(
        'place_of_interest_service',
        'place_of_interest',
        array(
            'labels' => array(
                'name' => 'Service type',
                'add_new_item' => 'Add New Place Of Interest Map',
                'new_item_name' => "New Map "
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
        )
    );




  }



public static function db_post( $place_of_interest_id, $place_of_interest ) {


 $slug = 'place_of_interest';



if ( get_post_status( $place_of_interest_id) == 'publish' && $slug == $place_of_interest->post_type )


{

        $term_list = wp_get_post_terms($place_of_interest_id, 'place_of_interest_service', array("fields" => "all"));

        $tax = $term_list[0]->name;

if ( !isset( $tax ) && $tax == '' ) {
           
             wp_die( "Please select the option that best describes your place of interest's type of service", 'Dragon Bay Inn' ) ; }
        

$term_list = wp_get_post_terms($place_of_interest_id, 'place_of_interest_business', array("fields" => "all"));

        $tax = $term_list[0]->name;

       if ( !isset( $tax ) && $tax == '' ) {
           
             wp_die( "Please select the option that best describes your place of interest's type of business", 'Dragon Bay Inn' ) ; }


$term_list = wp_get_post_terms($place_of_interest_id, 'place_of_interest_map', array("fields" => "all"));

        $tax = $term_list[0]->name;

       if ( !isset( $tax ) && $tax == '' ) {
           
             wp_die( "Please select the map option that will be associated with your place of interest ", 'Dragon Bay Inn' ) ; }




      if ( isset( $_POST['fullname'] ) && $_POST['fullname'] != '' ) {
            update_post_meta( $place_of_interest_id, 'fullname', $_POST['fullname'] );
        }else{ wp_die( 'Please select a ', 'Dragon Bay Inn' ) ; }
        

        if ( isset( $_POST['company'] ) && $_POST['company'] != '' ) {
            update_post_meta( $place_of_interest_id, 'company', $_POST['company'] );
        }else{ wp_die( 'Please select a ', 'Dragon Bay Inn' ) ; }
        

        
        


        if ( isset( $_POST['latlng'] ) && $_POST['latlng'] != '' ) {
            update_post_meta( $place_of_interest_id, 'latlng', $_POST['latlng'] );
        }else{ wp_die( 'Please select a ', 'Dragon Bay Inn' ) ; }


        if ( isset( $_POST['country'] ) && $_POST['country'] != '' ) {
            update_post_meta( $place_of_interest_id, 'country', $_POST['country'] );
        }else{ wp_die( 'Please select a ', 'Dragon Bay Inn' ) ; }

        if ( isset( $_POST['address'] ) && $_POST['address'] != '' ) {
            update_post_meta( $place_of_interest_id, 'address', $_POST['address'] );
        }else{ wp_die( 'Please select a ', 'Dragon Bay Inn' ) ; }

if ( isset( $_POST['description'] ) && $_POST['description'] != '' ) {
            update_post_meta( $place_of_interest_id, 'description', $_POST['description'] );
        }else{ wp_die( 'Please select a ', 'Dragon Bay Inn' ) ; }
}



}


public static function jal_install_admin() { 


add_meta_box( 'details_meta_box','Place Of Interest Business Details',array( 'db','db_bd_ini'),'place_of_interest', 'normal', 'high');

add_meta_box( 'location_meta_box','Place Of Interest Location Details',array( 'db','db_ld_ini'),'place_of_interest', 'normal', 'high'
    );


}

public static function db_bd_ini($place_of_interest)
  

  {
 
 $place_contact_name = esc_html( get_post_meta( $place_of_interest->ID, 'fullname', true ) );

 $place_company_name = esc_html( get_post_meta( $place_of_interest->ID, 'company', true ) );

 $place_company_phone = esc_html( get_post_meta( $place_of_interest->ID, 'phone', true ) );

 $place_company_email = esc_html( get_post_meta( $place_of_interest->ID, 'email', true ) );

 $place_company_website = esc_html( get_post_meta( $place_of_interest->ID, 'website', true ) );
   
$place_company_description = esc_html( get_post_meta( $place_of_interest->ID, 'description', true ) );

?>
   
<table id='bd_details_table'> 
 
<tr> <td><label> What is the best contact name ?&nbsp;
 </label> </td> <td><input id="fullname" class="form-control" type="text" placeholder="" name="fullname" value="<?php echo $place_contact_name; ?>"/> </td></tr>

<tr> <td><label>What is your company name ?&nbsp;
</label> </td> <td><input id="companyname" class="form-control" type="text" placeholder="" name="company" value="<?php echo $place_company_name; ?>" /> </td></tr>

<tr> <td> <label>What is you business phone number ?&nbsp;
</label></td> <td><input id="businessphone" class="form-control" type="text" placeholder="" name="phone" value="<?php echo $place_company_phone; ?>"/> </td></tr>

<tr> <td> <label>What is your email ?&nbsp;
</label></td> <td> <input id="email" name="email" class="form-control" type="text" placeholder="" value="<?php echo $place_company_email; ?>"/></td></tr>

<tr> <td> <label>What is your website url ?&nbsp;
</label></td> <td> <input id="website" class="form-control" type="text" placeholder="" name="website" value="<?php echo $place_company_website; ?>" /></td></tr>


<tr> <td> <label>How would you describe this place of interest?&nbsp;
</label></td> <td> <textarea id="description" class="form-control"  placeholder="" name="description" value="<?php echo $place_company_description; ?>" ></textarea></td></tr>

</table>

    <?php

  }

function db_ld_ini( $place_of_interest ) { 


 $place_company_latlng = esc_html( get_post_meta( $place_of_interest->ID, 'latlng', true ) );

 $place_company_business = esc_html( get_post_meta( $place_of_interest->ID, 'address', true ) );
   



?>
  
<p>What area will your map display </p> </br> <select class="form-control"  name='country'>';

<?php

$conn = new mysqli("localhost","udigitalmedia","321123Etz$","dragonbayinn");

$result = $conn->query("SELECT * FROM caribbeancountryTable ORDER BY country ASC");

while($row = $result->fetch_array())


{


echo "<option value='$row[country]'> $row[country] </option>";


}

?>

echo'

</select>
</br>
</br>
<input id="address" class="form-control" type="text" placeholder="What is your business address ?" name="address" value="<?php echo $place_company_business; ?>"/>

</br></br>

<div id="divformap" class="divformap">

<iframe src="http://dragonbayinnjamaica.com/testmap.php" width="100%" height="250" scrolling="no" seamless="seamless" id="mapframe" class="mapframe" ></iframe>

</div> 


<input type="hidden" name="latlng" id="latlng" value="<?php echo $place_company_latlng; ?>"/>

<div id="multiplelist" class="multiplelist"> 

<?php

$directory = '/home/udigitalmedia32/public_html/dragonbayinnjamaica.com/wp-content/plugins/DragonBayInn/images/mapicons/';


$scanned_directory = array_diff(scandir($directory), array('..', '.'));



foreach ($scanned_directory as $value)

{

$src = $directory.$value;


echo '<span> <img class="thumb" src="'.$src.'"/></span>';

}

?>

</div>


    <?php


}


}

 
?>