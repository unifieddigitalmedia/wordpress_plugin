<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class clearbooking_reserve_menu_items


{


public static function clearbooking_reserve_menu_items_create()


  {



 add_menu_page('Clear Booking', 'Clear Booking', 'manage_options', 'cbreserve',array('clearbooking_reserve_menu_items','clearbooking_top_menu_page_callback'));


 add_submenu_page( 'cbreserve', 'Instructions', 'Instructions', 'manage_options', 'cb_instruction', array('clearbooking_reserve_menu_items','clearbooking_top_menu_page_callback'));


 add_submenu_page( 'cbreserve', 'Settings', 'Settings', 'manage_options', 'cb_settings', array('clearbooking_reserve_menu_items','clearbooking_settings_submenu_page_callback'));



  }




public static function clearbooking_top_menu_page_callback()

{

?>

<h3> Set up instructions </h3> 

<p> Clear Booking installation is easy. Simple place the following HTML shortcode <span style="color:red;"> [clearbooking_calendar] </span> on any page and load the CLear Booking caldenadr widget.</p> 

<p> Once you have specified your reservation page, reservation details page and checkout page Clear Booking reservation will do the rest. When checking out, data is passed to your checkout page using the belowing query parameters for easy integration with your checkout page using PHP.</p>

<p>URL query parameters sent to checkout page are : </p>

<ul style="list-type:number">

<li >  reservationID  </li>

<li> fullamount </li>

<li> deposit </li>

</ul>

<?php

}

public static function clearbooking_settings_submenu_page_callback()

{

?>




      <div class="wrap">


<?php


if(isset( $_POST['form_submitted'] ))

{


if ( 
    ! isset( $_POST['clear_booking_menu_security_nonce'] ) 
    || ! wp_verify_nonce( $_POST['clear_booking_menu_security_nonce'], 'clear_booking_menu_security_check' ) 
) {

   print 'Sorry, your nonce did not verify.';
   exit;

} else {


 if ( isset( $_POST['cb_reservation_page'] ) ) {
 

        update_option( "cb_reservation_page", sanitize_text_field( $_POST['cb_reservation_page']) );
 
    } 
 if ( isset( $_POST['cb_checkout_page'] ) ) {
 

        update_option( "cb_checkout_page", sanitize_text_field( $_POST['cb_checkout_page']) );
 
    } 



 if ( isset( $_POST['cb_details_page'] ) ) {
 

        update_option( "cb_details_page", sanitize_text_field( $_POST['cb_details_page']) );
 
    } 

 if ( isset( $_POST['cb_terms_page'] ) ) {
 

        update_option( "cb_terms_page", sanitize_text_field( $_POST['cb_terms_page']) );
 
    } 



if ( isset( $_POST['cb_site_url'] ) ) {
 

        update_option( "cb_site_url", esc_url( $_POST['cb_site_url']) );
 
    } 



if ( isset( $_POST['cb_email'] ) ) {
 

        update_option( "cb_email", sanitize_email( $_POST['cb_email']) );
 
    } 


 if ( isset( $_POST['cb_url'] ) ) {
 

        update_option( "cb_url", esc_url( $_POST['cb_url']) );
 
    } 


 if ( isset( $_POST['cb_deposit_policy'] ) ) {
 

        update_option( "cb_deposit_policy", sanitize_text_field( $_POST['cb_deposit_policy']) );
 
    } 


     if ( isset( $_POST['cb_cancel_policy'] ) ) {
 

        update_option( "cb_cancel_policy", sanitize_text_field( $_POST['cb_cancel_policy']) );
 
    } 


     if ( isset( $_POST['cb_refund_policy'] ) ) {
 

        update_option( "cb_refund_policy", sanitize_text_field( $_POST['cb_refund_policy']) );
 
    } 



 if ( isset( $_POST['cb_tax'] ) ) {
 

        update_option( "cb_tax", sanitize_text_field( $_POST['cb_tax']) );
 
    } 



        update_option( "cb_customerconfirmationemail", sanitize_email( $_POST['cb_customerconfirmationemail']) );
 
  


        update_option( "cb_businessconfirmationemail", sanitize_email( $_POST['cb_businessconfirmationemail']) );
 
   

 if ( isset( $_POST['cb_business_address'] ) ) {
 

        update_option( "cb_business_address", sanitize_text_field( $_POST['cb_business_address']) );
 
    } 



 if ( isset( $_POST['cb_business_name'] ) ) {
 

        update_option( "cb_business_name", sanitize_text_field( $_POST['cb_business_name']) );
 
    } 



 if ( isset( $_POST['cb_business_phone'] ) ) {
 

        update_option( "cb_business_phone", sanitize_text_field( $_POST['cb_business_phone']) );
 
    } 



}


}


?>

 <?php
            
       

$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';

$section_tab = isset( $_GET[ 'section' ] ) ? $_GET[ 'section' ] : 'main';

 ?>

      <div id="icon-tools" class="icon32"></div>
      <h2>Clear Booking Settings Page</h2>
      <h2 class="nav-tab-wrapper">
      <a href="?page=cb_settings&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>">General</a>
      <a href="?page=cb_settings&tab=checkout" class="nav-tab <?php echo $active_tab == 'checkout' ? 'nav-tab-active' : ''; ?>">Checkout</a>
      <a href="?page=cb_settings&tab=tax" class="nav-tab <?php echo $active_tab == 'tax' ? 'nav-tab-active' : ''; ?>">Tax</a>
      </h2>
      </div>


<form method="post" action="">
  
<input type="hidden" name="clear_booking_menu_security_check" value="SUBMIT" /> 

   <?php wp_nonce_field( 'clear_booking_menu_security_check', 'clear_booking_menu_security_nonce' ); ?>

    <?php settings_fields( 'cb-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'cb-plugin-settings-group' ); ?>

<?php
         if($active_tab == 'checkout' ) 
{ ?>

  




   
<?php
         if($section_tab == 'main' ) 


{    ?>


<h3> Checkout </h3> 

<p>These pages need to be set so that Dragon Bay Inn Reserve knows where to send users when they have completed there reservation.</p>

<table>
<tr> <td>
<label> Reservation page </label></td>
<td>
<select name='cb_reservation_page'>
<option value="" >  </option>
<?php

global $post;

$args = array( 'posts_per_page' => -1 , 'post_type' => 'page');

$myposts = get_posts( $args );

foreach ( $myposts as $post ) : setup_postdata( $post ); 

if($post->post_name == get_option('cb_reservation_page'))

{

echo '<option value="'.esc_attr($post->post_name).'"   selected="selected"   >'.esc_attr(get_the_title($post->ID)).'</option>';

}
else

{

echo '<option value="'.esc_attr($post->post_name).'"      >'.esc_attr(get_the_title($post->ID)).'</option>';

}

endforeach; 


?>
</select></td></tr>
<tr> <td>
<label> Reservation Details page <label></td>
<td>
<select name='cb_details_page'>
<option value="" >  </option>
<?php

global $post;

$args = array( 'posts_per_page' => -1 , 'post_type' => 'page');

$myposts = get_posts( $args );

foreach ( $myposts as $post ) : setup_postdata( $post ); 

if($post->post_name == get_option('cb_details_page'))
{

echo '<option value="'.esc_attr($post->post_name).'"   selected="selected"   >'.esc_attr(get_the_title($post->ID)).'</option>';
}
else
{

echo '<option value="'.esc_attr($post->post_name).'"      >'.esc_attr(get_the_title($post->ID)).'</option>';

}


endforeach; 


?>
</select></td> </tr>


<tr> <td>
<label> Checkout page</label></td>
<td>
<select name='cb_checkout_page'>
<option value="" >  </option>
<?php

global $post;

$args = array( 'posts_per_page' => -1 , 'post_type' => 'page');

$myposts = get_posts( $args );

foreach ( $myposts as $post ) : setup_postdata( $post ); 

if($post->post_name == get_option('cb_checkout_page'))
{

echo '<option value="'.esc_attr($post->post_name).'"   selected="selected"   >'.esc_attr(get_the_title($post->ID)).'</option>';
}
else
{

echo '<option value="'.esc_attr($post->post_name).'"      >'.esc_attr(get_the_title($post->ID)).'</option>';

}
endforeach; 


?>
</select></td></tr>

<tr> <td>
<label> Terms and Conditions <label></td>
<td>
<select name='cb_terms_page'>
<option value="" >  </option>
<?php

global $post;

$args = array( 'posts_per_page' => -1 , 'post_type' => 'page');

$myposts = get_posts( $args );

foreach ( $myposts as $post ) : setup_postdata( $post ); 

if($post->post_name == get_option('cb_terms_page'))
{

echo '<option value="'.esc_attr($post->post_name).'"   selected="selected"   >'.esc_attr(get_the_title($post->ID)).'</option>';

}
else
{

echo '<option value="'.esc_attr($post->post_name).'"      >'.esc_attr(get_the_title($post->ID)).'</option>';

}

endforeach; 


?>

</select></td> </tr>

<tr> <td>
<label> Confirmation Email <label></td>
<td>

<input type="checkbox" name="cb_customerconfirmationemail" value="yes" 

<?php

if(get_option('cb_customerconfirmationemail') == 'yes' ){

 echo "checked";


}


?>

> Send confirmation email to customer when checking out
<br>


</td> </tr>


<tr> <td>
<label>  <label></td>
<td>

<input type="checkbox" name="cb_businessconfirmationemail" value="yes" 

<?php

if(get_option('cb_businessconfirmationemail') == 'yes' ){

 echo "checked";


}


?>



> Send confirmation email to your business email when customer is checking out
<br>


</td> </tr>

</table>
</br>


<?php


}
        else if( $section_tab == 'cash' ) {    ?>




<?php


} else if( $section_tab == 'paypal' ) {    ?>





<?php


}


?>






<?php


}
        else if( $active_tab == 'general' ) { ?>


<h3> General settings </h3>


<table>

<tr> <td>

<label> Your business name <label></td>

<td>

<input type="text" size ="50" name="cb_business_name" value="<?php $cb_business_name = esc_attr(get_option('cb_business_name')); echo $cb_business_name;  ?>">

</td> </tr>


<tr> <td>

<label> Your business phone <label></td>

<td>

<input type="text" size ="50" name="cb_business_phone" value="<?php $cb_business_phone = esc_attr(get_option('cb_business_phone')); echo $cb_business_phone;  ?>">

</td> </tr>


<tr> <td>

<label> Your business address <label></td>

<td>

<input type="text" size ="50" name="cb_business_address" value="<?php $cb_business_address = esc_attr(get_option('cb_business_address')); echo $cb_business_address;  ?>">

</td> </tr>

<tr> <td colspan="2">

<label> *the above details will be used in confirmation emails sent to you customers once they have checked out. 
<label></td>

</tr>


<tr> <td>

<label> Your website url <label></td>

<td>

<input type="text" size ="50" name="cb_url" value="<?php $cb_url = get_option('cb_url'); echo esc_attr($cb_url);  ?>">

</td> </tr>


</table>


<table>

<tr> <td>

<label> Your business email *this will be used to send you a confirmation slip of new reservations <label></td>

<td>

<input type="text" size ="50" name="cb_email" value="<?php $cb_email = get_option('cb_email'); echo esc_attr($cb_email);  ?>">

</td> </tr>


</table>




<h3> Your deposit policy</h3> 

<textarea rows="4" cols="50" name="cb_deposit_policy" > <?php $cb_deposit_policy = get_option('cb_deposit_policy'); echo esc_attr($cb_deposit_policy); ?> </textarea>

<h3> Your cancellation policy </h3> 

<textarea rows="4" cols="50" name="cb_cancel_policy" ><?php $cb_cancel_policy = get_option('cb_cancel_policy'); echo esc_attr($cb_cancel_policy); ?> </textarea>

<h3> Your refund policy</h3> 

<textarea rows="4" cols="50" name="cb_refund_policy"  ><?php $cb_refund_policy = get_option('cb_refund_policy'); echo esc_attr($cb_refund_policy) ; ?> </textarea>





<h3> Currency Options </h3> 

<p>The following options affect how prices are displayed on the frontend.
</p>

<table>
<tr> <td>
<label> Currency <label></td>
<td>
<select name='cb_curreny'>
<?php

global $post;

$args = array( 'posts_per_page' => -1 , 'post_type' => 'page');

$myposts = get_posts( $args );

foreach ( $myposts as $post ) : setup_postdata( $post ); 

echo '<option value="'.$post->post_name.'">'.get_the_title($post->ID).'</option>';
endforeach; 



?>

</select></td> </tr></table>


<?php


} else if( $active_tab == 'tax' ) { ?>


<table>

<tr> <td>

<label> Your tax amount  <label></td>

<td>

<input type="text" size ="10" name="cb_tax" value="<?php $cb_tax = get_option('cb_tax'); echo esc_attr($cb_tax);  ?>"> %

</td> </tr>


</table>

<?php


}


?>

<input type="hidden" name='form_submitted' value ='Submit' />

    <?php submit_button(); ?>

</form>

<?php


}



}


?>