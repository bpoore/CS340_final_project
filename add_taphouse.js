$(document).ready(function () {
	$("#sub").click(function() {
		$.post($("#add_taphouse").attr('action'), $('#add_taphouse :input').serializeArray(), function(info) {
				$("#result").html(info);
			});
		clearInput();
	});
	
	$("#add_taphouse").submit( function () {
	return false;
	});
	
	function clearInput() {
    	$("#add_taphouse :input").each( function() {
       		$(this).val('');
    	});
	}
});

