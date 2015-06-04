$(function(){

	var xhr;
	$("#autocomplete").autocomplete({
		delay: 0,
		source: function( request, response ) {
			var regex = new RegExp(request.term, 'i');
			if(xhr){
			xhr.abort();
			}
			xhr = $.ajax({
				url: "AllCards.json",
				dataType: "json",
				cache: false,
				success: function(data) {
					var result = $.map(data, function(item) {
						if(regex.test(item.name)){
							return {
								label: item.name
								};
						}
					});
					response(result.slice(0,10));
				}
			});
		},
		minlength:0
	});
});