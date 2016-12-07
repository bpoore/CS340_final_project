/*$(document).ready(function () {
	done();
});
 
function done() {
	  setTimeout( function() { 
	  updates(); 
	  done();
	  }, 200);
}
 
function updates() {
	$.getJSON("fetch_on_tap.php", function(data) {
	       $("#on_tap").empty();
		   $.each(data.result, function(){
		   	console.log(data.result);
		   		$("#on_tap").append("<tr><td>"+this['brewery']+"</td><td>" +this['beer']+"</td><td>" +this['pint_price']+"</td><td>"+this['growler_price']+"</td><td><form method='post' action='delete_beer_at_location.php'><input type='hidden' name='beer_on_tap_id' value='"+$this['id']+"'><input type='submit' value='Remove' class='btn btn-danger'></form></td></tr>");
		});
	 });
} */

$(document).ready(function () {
	$.getJSON("fetch_on_tap.php", function(data) {
	       $("#on_tap").empty();
		   $.each(data.result, function(){
		   	console.log(data.result);
		   		$("#on_tap").append("<tr><td>"+this['brewery']+"</td><td>" +this['beer']+"</td><td>" +this['pint_price']+"</td><td>"+this['growler_price']+"</td><td><form method='post' action='delete_beer_at_location.php'><input type='hidden' name='beer_on_tap_id' value='"+$this['id']+"'><input type='submit' value='Remove' class='btn btn-danger'></form></td></tr>");
		});
	 });
});

