reservationrooms = [];

reservationcpns = [];

function checkavailability ()

{


var f = document.getElementById('fromdate').getAttribute('data-id');


var t = document.getElementById('todate').getAttribute('data-id');


var p = document.getElementById('promo').getAttribute('data-id');


if(f != "" || t != "")

{

var data = {

	 'security':'<?php jQueryajax_nonce = wp_create_nonce( "clear_booking_secure" ); echo jQueryajax_nonce; ?>',


              'action':'rooms',
              'from':f,
              'to':t,
              'dataType':'json',
                
           };



jQuery.post(ajax_object.ajax_url, data, function(response) {


jQuery(".arooms").html(response);

jQuery("#availablecol").slideDown("slow");



});






var data = {

	 'security':'<?php jQueryajax_nonce = wp_create_nonce( "clear_booking_secure" ); echo jQueryajax_nonce; ?>',


              'action':'offers',
              'fromdate':f,
              'todate':t,
              'promo':p,
             
                
           };





jQuery.post(ajax_object.ajax_url, data, function(response) {



jQuery(".acpns").html(response);

jQuery("#availablecoloffs").slideDown("slow");




});







}









}




function getResdetails(P){


var data = {

	 'security':'<?php jQueryajax_nonce = wp_create_nonce( "clear_booking_secure" ); echo jQueryajax_nonce; ?>',


              'action':'reservationdetails',
              'resID':P,
              'dataType':'json',
                
           };

jQuery.post(ajax_object.ajax_url, data, function(response) {



jQuery("#content").html(response);


});


}



function validateDates(from,to) {


var today = new Date();

var fromarray = from.split("/");

var toarray = to.split("/");

var startDate = new Date(fromarray[2],Number(fromarray[1])-1,fromarray[0]); 

var endDate = new Date(toarray[2],Number(toarray[1])-1,toarray[0]);



if( startDate > endDate )

{


return 'Please check you check out date.';


} 

else if(today > startDate || today > endDate)

{


return 'Dates cannot be in the past.';


}
else if( endDate ==  'Invalid Date' || startDate == 'Invalid Date')
{

return 'Please check your reservation dates.';


}

else
{

return '';


}

 

}

jQuery(document).ready(function() {


jQuery("#availablecol").hide();


jQuery("#availablecoloffs").hide();

jQuery("#bookingcol").hide();

jQuery("#ratescol").hide();

jQuery("#detailscol").hide();

jQuery(".checking").hide();

 jQuery("#plannedtripcodediv").hide();



jQuery('input[type=radio][name=plannedtrip]').change(function() {

        if (this.value == 'yes') {

          jQuery("#plannedtripcodediv").slideDown("slow");

        }
        else if (this.value == 'no') {

         jQuery("#plannedtripcodediv").slideUp("slow");

        }

    });


jQuery("#checkavailability").click(function(){




jQuery(".checking").slideDown("slow");


setTimeout(function(){ 


jQuery(".checking").slideUp("slow");


 }, 2000);


var error = validateDates(jQuery("#fromdate").val(),jQuery("#todate").val());

if(error == '')


{




document.getElementById("error").innerHTML = 'Checking availability';



setTimeout(function(){ 


jQuery("#calenderrow").slideUp("slow");

var d = document.getElementById("shortcodeform");



 }, 2000);



if (document.getElementById("shortcodeform")) 

{

setTimeout(function(){ 

document.getElementById("shortcodeform").submit();

 }, 2000);


}
else
{

var data = {

	 'security':'<?php jQueryajax_nonce = wp_create_nonce( "clear_booking_secure" ); echo jQueryajax_nonce; ?>',


              'action':'rooms',
              'from':jQuery("#fromdate").val(),
              'to':jQuery("#todate").val(),
              'dataType':'json',
                
           };



jQuery.post(ajax_object.ajax_url, data, function(response) {


jQuery(".arooms").html(response);

jQuery("#availablecol").slideDown("slow");



});






var data = {

	 'security':'<?php jQueryajax_nonce = wp_create_nonce( "clear_booking_secure" ); echo jQueryajax_nonce; ?>',


              'action':'offers',
              'fromdate':jQuery("#fromdate").val(),
              'todate':jQuery("#todate").val(),
              'promo':jQuery("#promo").val(),
             
                
           };





jQuery.post(ajax_object.ajax_url, data, function(response) {



jQuery(".acpns").html(response);

jQuery("#availablecoloffs").slideDown("slow");




});



}


}
else
{

document.getElementById("error").innerHTML = error;

}



});



jQuery(document).on("click",".bkngrmrmv",function(event){

bkngrm = jQuery(this).attr("data-id");

reservationrooms = jQuery.grep(reservationrooms, function( a,i ) { 


return ( a.id !== bkngrm ); 



});



        bkng();

});


jQuery(document).on("click","#roombtn",function(event){



if(!rmad(jQuery(this).attr("value"),reservationrooms))

{



  var rm = {

    id : jQuery(this).attr("value"),
    adults:"0",
    children:"0",
    infants :"0"

};

  reservationrooms.push(rm);




}




      bkng();

});


jQuery(document).on("click","#cpnbtn",function(event){

if(!rmad(jQuery(this).attr("value"),reservationcpns))

{



  var rm = {


    id : jQuery(this).attr("value"),

           };

  reservationcpns.push(rm);


}




bkng();



});


jQuery(document).on("click",".cptrmrmv",function(event){

cptgrm = jQuery(this).attr("data-id");

reservationcpns = jQuery.grep(reservationcpns, function( a,i ) { 


return ( a.id !== cptgrm ); 



});


        bkng();

});




jQuery(document).on("click","#chkrates",function(event){

var addons = [];

var f = jQuery('input[type=radio]:checked');

for (var i = 0, length = f.length; i < length; i++) {

if(f[i].value == 'yes')

{



 addons.push(f[i].name);


}


}

adltIn = document.getElementsByName("adults");


cldIn  = document.getElementsByName("children");


iftIn  = document.getElementsByName("infants");



reservationrooms = jQuery.grep(reservationrooms, function( a,i ) { 



  a.adults = adltIn[i].value;

  a.children = cldIn[i].value;

  a.infants = iftIn[i].value;


return a; 

});



var data = {

	 'security':'<?php jQueryajax_nonce = wp_create_nonce( "clear_booking_secure" ); echo jQueryajax_nonce; ?>',

              'action':'bkngtlt',
              'bkng':reservationrooms,
              'bkngcpn':reservationcpns,
              'from':jQuery("#fromdate").val(),
              'to':jQuery("#todate").val(),
              'addOns[]':addons,
              'token':jQuery("#plannedtrip").val()
              
           };

jQuery.getJSON(ajax_object.ajax_url, data, function(response) {

jQuery(".rtsrms").html(response[0]);

jQuery(".rtsoffs").html(response[1]);

jQuery(".rtstlt").html(response[3]);

jQuery("#chkbtn").val(response[2]);

jQuery(".chkbtn").val(response[2]);

jQuery(".rtsaddons").html(response[4]);

jQuery(".taxamt").html(response[5]);


jQuery("#ratescol").slideDown("slow");

jQuery("html,body").animate({scrollTop:jQuery("#ratescol").offset().top }, "slow");



});



});

jQuery(document).on("click","#totalid",function(event){



jQuery("#detailscol").slideDown("slow");


jQuery("html,body").animate({scrollTop:jQuery("#detailscol").offset().top }, "slow");


});



jQuery(document).on("click","#chkbtn",function(event){


var x = document.getElementById("ckhterms").checked;


if( jQuery("#resfirstname").val() === jQuery("#resfirstname").attr('placeholder') || jQuery("#reslastname").val() === jQuery("#reslastname").attr('placeholder')  || jQuery("#resphone").val() === jQuery("#resphone").attr('placeholder')  || jQuery("#resemail").val() === jQuery("#resemail").attr('placeholder') )

{




document.getElementById("detailserror").innerHTML = 'All fields are required';


}


else 


{






if(document.getElementById("ckhterms").checked)
{




var data = {

	 'security':'<?php jQueryajax_nonce = wp_create_nonce( "clear_booking_secure" ); echo jQueryajax_nonce; ?>',


              'action':'resdetails',
              'reservationID':jQuery(this).attr("value"),
              'firstname':jQuery("#resfirstname").val(),
              'lastname':jQuery("#reslastname").val(),
              'phone':jQuery("#resphone").val(),
              'email':jQuery("#resemail").val(),
            
                

           };

jQuery.post(ajax_object.ajax_url, data, function(response) {



document.getElementById("detailsform").submit();

});



}
else

{


document.getElementById("detailserror").innerHTML = 'You need to agree to our terms and conditions';


}










}






});
function rmad(para,para1) {




for (i = 0; i < para1.length; i++  )


{

if( para1[i].id === para )

{


return true;


}



}


return false;

}



function bkng () {




var data = {

	 'security':'<?php jQueryajax_nonce = wp_create_nonce( "clear_booking_secure" ); echo jQueryajax_nonce; ?>',


              'action':'bkng',
              'bkng':reservationrooms,
              'bkngcpn':reservationcpns,

                
           };




jQuery.getJSON(ajax_object.ajax_url, data, function(response) {




jQuery(".bkng").html(response[0]);

jQuery(".bkngcpt").html(response[1]);

jQuery(".bkngaddons").html(response[2]);


jQuery("#bookingcol").slideDown("slow");

});



}



jQuery("#calenderrow").hide();



var newdate = new Date();

var current_month = newdate.getMonth();

var current_year = newdate.getFullYear();




jQuery("#fromdate").click(function(){



var data = {

	 'security':'<?php jQueryajax_nonce = wp_create_nonce( "clear_booking_secure" ); echo jQueryajax_nonce; ?>',


              'action':'loadcal',
              'month':current_month,
              'dataType':'json',
                
           };



jQuery.post(ajax_object.ajax_url, data, function(response) {

jQuery("#frommonth").html(response);

});



var data = {

	 'security':'<?php jQueryajax_nonce = wp_create_nonce( "clear_booking_secure" ); echo jQueryajax_nonce; ?>',


              'action':'loadcalto',
              'month':current_month,
              'dataType':'json',
                
           };


jQuery.post(ajax_object.ajax_url, data, function(response) {


jQuery("#tomonth").html(response);


jQuery("#calenderrow").slideDown("slow");

});








});


jQuery(document).on("click", ".daydiv", function(){



current_year = Number(current_month)  < getmonth() ?  newdate.getFullYear() + 1 : newdate.getFullYear() ;


var fromdate = jQuery(this).html()+'/'+jQuery(this).attr("data-id")+'/'+current_year;

jQuery("#fromdate").val(fromdate);

current_month = getmonth();


 });


jQuery(document).on("click", ".todaydiv", function(){



current_year = Number(current_month)  < getmonth() ?  newdate.getFullYear() + 1 : newdate.getFullYear() ;


  
var todate = jQuery(this).html()+'/'+jQuery(this).attr("data-id")+'/'+current_year;



jQuery("#todate").val(todate);

current_month = getmonth();




 });



function getmonth() {


var newdate = new Date();

return newdate.getMonth();


}



jQuery(document).on("click", ".frompre", function(){



current_month =  Number(current_month) ==  getmonth() ?  getmonth() : (Number(current_month) <= 0 ? Number(12) - 1:Number(current_month) - 1);



current_year = Number(current_month)  < getmonth() ?  newdate.getFullYear() + 1 : newdate.getFullYear() ;



var data = {

	 'security':'<?php jQueryajax_nonce = wp_create_nonce( "clear_booking_secure" ); echo jQueryajax_nonce; ?>',


              'action':'loadcal',
              'month':current_month,
              'dataType':'json',
                

           };



jQuery.post(ajax_object.ajax_url, data, function(response) {


jQuery("#frommonth").html(response);



});






 });


jQuery(document).on("click", ".fromnxt", function(){

current_month = Number(current_month) < Number(12) -1 ? ( Number(current_month) == Number(getmonth()) - 1 ? getmonth() - 1 : Number(current_month) + 1) : 0;


current_year = Number(current_month)  < getmonth() ?  newdate.getFullYear() + 1 : newdate.getFullYear() ;

var data = {

	 'security':'<?php jQueryajax_nonce = wp_create_nonce( "clear_booking_secure" ); echo jQueryajax_nonce; ?>',


              'action':'loadcal',
              'month':current_month,
              'dataType':'json',
                
           };



jQuery.post(ajax_object.ajax_url, data, function(response) {

jQuery("#frommonth").html(response);

});


 });


jQuery(document).on("click", ".topre", function(){



current_month =  Number(current_month) ==  getmonth() ?  getmonth() : (Number(current_month) <= 0 ? Number(12) - 1:Number(current_month) - 1);

current_year = Number(current_month)  < getmonth() ?  newdate.getFullYear() + 1 : newdate.getFullYear() ;


var data = {

	 'security':'<?php jQueryajax_nonce = wp_create_nonce( "clear_booking_secure" ); echo jQueryajax_nonce; ?>',


              'action':'loadcalto',
              'month':current_month,
              'dataType':'json',
                
           };



jQuery.post(ajax_object.ajax_url, data, function(response) {


jQuery("#tomonth").html(response);



});






 });


jQuery(document).on("click", ".tonxt", function(){

current_month = Number(current_month) < Number(12) -1 ? ( Number(current_month) == Number(getmonth()) - 1 ? getmonth() - 1 : Number(current_month) + 1) : 0;

current_year = Number(current_month)  < getmonth() ?  newdate.getFullYear() + 1 : newdate.getFullYear() ;


var data = {

	 'security':'<?php jQueryajax_nonce = wp_create_nonce( "clear_booking_secure" ); echo jQueryajax_nonce; ?>',


              'action':'loadcalto',
              'month':current_month,
              'dataType':'json',
                
           };



jQuery.post(ajax_object.ajax_url, data, function(response) {

jQuery("#tomonth").html(response);

});


 });

jQuery("#cpassworddiv").hide();

jQuery(document).on("click", "#signupbtn", function(){

var value = jQuery("#cpassword").val();

var atpos= jQuery("#username").val().indexOf("@");

var dotpos= jQuery("#username").val().lastIndexOf(".");

if(jQuery("#username").val() == '' || jQuery("#password").val() == '')

{

document.getElementById("error").innerHTML = 'Both fields are required';


}
else if(atpos < 1 || dotpos < atpos+2 || dotpos+2 >= jQuery("#username").val().length)
{

document.getElementById("error").innerHTML = 'Please check your email';


}
else if(value.length < 8) 
{


document.getElementById("error").innerHTML = 'Password must be at least 8 characters in length';


}
else if(jQuery("#cpassword").val() == '') 
{

document.getElementById("error").innerHTML = 'Please confirm your password';


jQuery("#cpassworddiv").slideDown("slow");


}

else if(jQuery("#cpassword").val() != jQuery("#password").val()) 

{


jQuery("#cpassworddiv").slideDown("slow");


document.getElementById("error").innerHTML = 'Passwords do not match';


}
else
{

var data = {

	 'security':'<?php jQueryajax_nonce = wp_create_nonce( "clear_booking_secure" ); echo jQueryajax_nonce; ?>',


              'action':'signup',
              'email':jQuery("#username").val(),
              'password':jQuery("#cpassword").val(),
              'dataType':'json',
                
           };



jQuery.post(ajax_object.ajax_url, data, function(response) {

if(response == 'Clear')

{

document.getElementById("confirmform").submit();

}


else

{

document.getElementById("error").innerHTML = response;

}



});


}




});


});

       