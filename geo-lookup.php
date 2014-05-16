$(function() {

	$( "#city" ).autocomplete({
		source: function( request, response ) {
//			console.log("begin search");
			$.ajax({
				url: "http://ws.geonames.org/searchJSON",
				dataType: "jsonp",
				data: {
					featureClass: "P",
					style: "full",
					maxRows: 3,
					name_startsWith: request.term
				},
				success: function( data ) {
					response( $.map( data.geonames, function( item ) {
						return {
							label: item.name + ", " + item.countryName,
							value: item.name + ", " + item.countryName
						}
					}));
				}
			});
		},
		minLength: 2,
		select: function( event, ui ) {
		  jQuery("#location-str").html("Location: "+ui.item.value);
		  jQuery("#myLocation").val(ui.item.value);
		  this.autocomplete('close');
		},
		open: function() {
			$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
		},
		close: function() {
			$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
		}
	});
});
