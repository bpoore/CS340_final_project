$(document).ready(function () {
	$("#sub").click(function() {
		$.post($("#add_beer").attr('action'), $('#add_beer :input').serializeArray(), function(info) {
				$("#result").html(info);
			});
		clearInput();
	});
	
	$("#add_beer").submit( function () {
	return false;
	});
	
	function clearInput() {
    	$("#add_beer :input").each( function() {
       		$(this).val('');
    	});
	}
});




