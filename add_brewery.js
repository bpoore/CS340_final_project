$(document).ready(function () {
	$("#sub").click(function() {
		$.post($("#add_brewery").attr('action'), $('#add_brewery :input').serializeArray(), function(info) {
			$("#result").html(info);
			});
		clearInput();
	});
	
	$("#add_brewery").submit( function () {
		return false;
	});

	function clearInput() {
    	$("#add_brewery :input").each( function() {
       		$(this).val('');
    	});
	}
});



