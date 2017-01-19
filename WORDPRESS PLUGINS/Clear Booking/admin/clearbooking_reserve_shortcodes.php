<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class clearbooking_reserve_shortcodes

{
     



function clearbooking_reserve_shortcode($atts) {


      
    ob_start();

    


     

    ?>

 









<form action="<?php $reservation_page = get_option('cb_reservation_page'); echo $reservation_page;  ?>/"  method="post" id="shortcodeform" class="shortcodeform" name="shortcodeform">
 


<div class="row" ng-hide='availabilty'>

<div class="col-sm-3" id='checkavaiabiltyrow' >

<div class="form-group has-success has-feedback" style="text-align:right;">

<h3> Reserve online </h3>


</div> 



</div>



<div class="col-sm-2" id='checkavaiabiltyrow' >

<div class="form-group has-success has-feedback">

<input type="text" class="form-control"  id="fromdate" name="from" > 

<span class="glyphicon glyphicon-th form-control-feedback"></span> 

</input> 

</div>

<script type="text/javascript">

            jQuery(document).ready(function() {

jQuery(function() {

                jQuery('#fromdate').datepicker({
                   
      defaultDate: "+1w",
      dateFormat: 'dd-mm-yy',
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {

        $( "#todate" ).datepicker( "option", "minDate", selectedDate );

      }


                });

            jQuery('#todate').datepicker({
                   
      defaultDate: "+1w",
      dateFormat: 'dd-mm-yy',
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {

        $( "#fromdate" ).datepicker( "option", "maxDate", selectedDate );

      }


                });

            });

        });

        </script>    

</div>

<div class="col-sm-2" id='checkavaiabiltyrow' >

<div class="form-group has-success has-feedback">

<input type="text" class="form-control" id="todate"  name="to"> 

<span class="glyphicon glyphicon-th form-control-feedback"></span>  

</input> 

</div>

</div>

<script type="text/javascript">

           
        </script>  

<div class="col-sm-2" id='checkavaiabiltyrow' >

<div class="form-group has-success has-feedback">

<input id="promo" class="form-control" type="text" placeholder="PROMO CODE" name='promo' /> 

<span class="glyphicon glyphicon-qrcode form-control-feedback"></span>

</div>

</div>

<div class="col-sm-3" id='checkavaiabiltyrow' >

<button class="btn btn-default btn-block" type="button"  id="checkavailability">CHECK AVAILABILITY</button> 

</div>

</div>

</div>

<div id='errormessage' class='checking'> <p id="error">  </p> </div>

<div class="row" id='calenderrow'>
<div class="col-sm-6" id="frommonth">

</div>

<div class="col-sm-6" id="tomonth">

</div>


</div>

</form>


 <?php 

   

    return ob_get_clean();




    }



	








}






?>