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
	$.getJSON("fetch_taphouses.php", function(data) {
	       $("#taphouse_list").empty();
		   $.each(data.result, function(){
		   		$("#taphouse_list").append("<tr><td>"+this['name']+"</td><td>" +this['street_address']+"</td><td>"+this['city']+"</td><td>"+this['state']+"</td><td>"+this['open']+"</td><td>"+this['close']+"</td><td><form method='post' action='taphouse_data.php'><input type='hidden' name='taphouse_id' value='"+this['id']+"'><input type='submit' value='update' class='btn btn-info'></form></td></tr>");
		});
	 });
}