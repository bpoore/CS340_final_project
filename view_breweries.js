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
	$.getJSON("fetch_breweries.php", function(data) {
	       $("#brewery_list").empty();
		   $.each(data.result, function(){
		   		$("#brewery_list").append("<tr><td>"+this['name']+"</td><td>" +this['city']+"</td><td>" +this['state']+"</td></tr>");
		});
	 });
}