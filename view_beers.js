$(document).ready(function () {
	done();
});
 
function done() {
	  setTimeout( function() { 
	  updates(); 
	  done();
	  }, 200);
}
 
function updates() {
	$.getJSON("fetch_beers.php", function(data) {
	       $("#beer_list").empty();
		   $.each(data.result, function(){
		   		$("#beer_list").append("<tr><td>"+this['name']+"</td><td>" +this['type']+"</td><td>" +this['abv']+"</td><td>" +this['brewery']+"</td></tr>");
		});
	 });
}