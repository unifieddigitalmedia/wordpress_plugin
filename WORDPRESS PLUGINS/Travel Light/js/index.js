jQuery(document).ready(function($) {

$(document).on("change","#taxselect",function(event){


$(".txtinput").val(this.value);

$(".taxselect").val();


});


$(document).on("change","#businessselect",function(event){


var data = {
		'action': 'filter_serviceaction',
                'typeofb': this.value,
               

	};



jQuery.post(ajax_object.ajax_url, data, function(response) {


$(".dbtofser").html(response);


});


});

});

document.getElementById('address').addEventListener('change', function() {
  
var address = this.value;

var geocoder;

geocoder = new google.maps.Geocoder();

geocoder.geocode( { 'address': address}, function(results, status) {

if (status == google.maps.GeocoderStatus.OK) {

var x = document.getElementById("mapframe");

var y = (x.contentWindow || x.contentDocument);

if (y.document)y = y.document;

document.getElementById("latlng").value = results[0].geometry.location ;

var map = new google.maps.Map(y.getElementById('map'), {

center:results[0].geometry.location,

zoom:16,

mapTypeId:google.maps.MapTypeId.ROADMAP

  });


}



 });



}, false);
