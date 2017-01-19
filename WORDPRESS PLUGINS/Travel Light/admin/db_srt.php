<?php


class db_srt

{
  
       function init() {


		add_shortcode('places-of-interest', array(__CLASS__, 'handle_shortcode'));



$args = array( 'hide_empty' => false ); 

$taxonomies = array('place_of_interest_map');

$countries = array();

$countries = get_terms('place_of_interest_map',$args);



	}


 function handle_shortcode($atts) {


         $a = shortcode_atts( array('map' => 'something'), $atts ,'places-of-interest');

ob_start();

    


        


 ?>

<iframe src="<?php $r = get_option('siteurl').'/wp-content/plugins/DragonBayInn/includes/db_map.php?location='.$a[map];  echo $r; ?>"  scrolling="no" seamless="seamless" id="frontendmapframe" data-id="<?php echo $a[map];  ?>"></iframe>


<form action='' method='get' name='shortcode' id='shortcode' class='shortcode'>

<div id="outer" ng-controller="ReservationController"  class="container-fluid"  >

<div class="container-fluid" id="leftdiv" >

<div class="row">

<div class="col-sm-4" id="leftcol"> 

<div class="row">
<div class="col-sm-12" id="firstrow" > REFINE YOUR EXPERIENCE </div>
</div>

<div id="panela1" class="panela1">


<div class="row" id="containerdiv" >

  <div class="col-sm-12" id="secondrow"  > Venue: </div>


</div>


<div class="row" id="containerdiv" >

<div class="col-sm-12"  id="thridrow"> 


<input id="place" class="target"  name="place" type="text" onkeydown="searchbrand()"/> 


</div>

</div>



<div class="row" id="containerdiv" >

  <div class="col-sm-12" id="thridrow" > 


  <div id="fourthrowdiv" class="brandservice"> 



</div> 




  </div>


</div>




<div class="row" id="containerdiv" >

  <div class="col-sm-12"  id="thridrow"> 

Type of Service:

  </div>

</div>



<div class="row" id="containerdiv" >

  <div class="col-sm-12"  id="thridrow"> 

<div id="fourthrowdiv" class="typeofservice" >



</div> 


  </div>

</div>



<div class="row" id="containerdiv" >

  <div class="col-sm-12"  id="thridrow"> 

Special Interest:

  </div>

</div>



<div class="row" id="containerdiv" >

  <div class="col-sm-12"  id="thridrow"> 

<div id="fourthrowdiv" class='typeofbusiness' >



<?php 


$args = array( 'hide_empty' => false,'orderby'=> 'name','order'=> 'ASC');

$terms = get_terms('place_of_interest_business',$args);




foreach ($terms as $term)

{

$html .= '
  <div class="row">
  <div class="col-sm-8">'.$term->name .'</div>
  <div class="col-sm-4" id="call-back_bis" ><input value="'.$term->name.'"type="checkbox" class="dbtob" ></div>
  </div>';




}



echo $html;

 ?>

</div>

  </div>

</div>



<div class="row" id="containerdiv" >

  <div class="col-sm-12"  id="thridrow"> 

Country:

  </div>

</div>



<div class="row" id="containerdiv" >

  <div class="col-sm-12"  id="thridrow"> 

<div id="fourthrowdivC">

<select  name='country' id='country' class='country' >

<option> </option>

<?php 

$args = array( 'hide_empty' => false ); 

$taxonomies = array('place_of_interest_map');

$countries = array();

$countries = get_terms('place_of_interest_map',$args);



foreach( $countries as $country )



        {

            


echo "<option value='$country->name'> $country->name </option>";




        }








 ?>


</select>
</form>
</div>

  </div>

</div>

<div class="row" id="containerdiv" >

  <div class="col-sm-12"  id="thridrow"> 



<button type="button" class="btn btn-default btn-lg btn-block" id="discover">Discover more</button>


<form action="../<?php $reservation_page = get_option('db_reservation_page'); echo $reservation_page;  ?>/" method="post" name="tripconfirmform" id="tripconfirmform" class="tripconfirmform" >
<input type="hidden" id="chktoken" class="chktoken" name="token" />
<div id="trpPlcs">

</div>
<input type="hidden" name="trip" value="submit"/>
<input type="hidden" name="distance" id="distance" class="distance"/>

<button type="button" class="btn btn-default btn-lg btn-block" id="tripconfirm" >Checkout</button>

</form>
</div>
</div>
</div>


</div>






<div class="col-sm-8" id="rightdiv" >


<div class="row" id="innerrightdiv">

  <div class="col-sm-6"> </div>

  <div class="col-sm-6" id="innerrightdivright"> <div id="trpcfm" class"trpcfm" >   

<div class="row"> <div class="col-sm-12" ><h5> Your trip is  </h5></div> </div>

<div class="row"> <div class="col-sm-12" ><h5 id="trpcfmdst" class="trpcfmdst">   </h5></div> </div>

<div class="row"> <div class="col-sm-12" ><h5 > Your planned trip code is below  </h5></div> </div>

<div class="row"> <div class="col-sm-12" ><h5 id="trpcode" class="trpcode">   </h5></div> </div>

</br>



</div>

</div>

</div>







 </div>

</div>

</div>



<div class="row" >

<div class="col-sm-12" id="rightmain"   > 

<div id="panelb1" class="panelb1"  >

</div>

</div>

</div>



</div>





    <?php 

   

    return ob_get_clean();

    }



	








}






?>