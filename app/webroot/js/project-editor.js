// map init
var mapOptions = {
	zoom: 16,
	mapTypeId: google.maps.MapTypeId.ROADMAP,
	disableDefaultUI: true,
	zoomControl: true,
};
var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
var geocoder = new google.maps.Geocoder();
var marker;

// address and map
$("#confirm-address").click(function() {
	var a = $(this);
	a.button("loading");

	var alert = a.next(".alert");
	
	var address  = $("[ng-model=addr1]").val() + $("[ng-model=addr2]").val() + $("[ng-model=addr3]").val() + $("[ng-model=addr4]").val() + $("[ng-model=addr5]").val();
	address = $.trim(address.replace(/,/g, " "));
	a.attr("data-address", address);

	geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			map.setCenter(results[0].geometry.location);
			marker = new google.maps.Marker({
				map: map,
				position: results[0].geometry.location,
				title: address
			});
			alert.hide().fadeIn().removeClass("alert-error").addClass("alert-success").text("Address has been confirmed!");

			// checking census tract
			var tractInput = $("#census-tract");
			var url = $.trim(tractInput.attr("data-url")) + results[0].geometry.location.jb + "/" + results[0].geometry.location.kb;
			$.getJSON(url, function(json) {
				if (json.status.toLowerCase() == "ok") {
					var tractText = json.Tract.FIPS + ", " + json.County.name + ", " + json.State.name;
					tractInput
						.val(tractText)
						.data("location-json", $.toJSON(json));
				}
			});
		} else {
			alert.hide().fadeIn().removeClass("alert-success").addClass("alert-error").text("Address confirmation failure due to " + status );
		}
	});
	a.button("reset");
});

// market area and expanded area
$("#market-area,#expanded-area").change(function() {
	var input = $(this);
	var address = input.find("option:selected").text() + ", Minnesota";
	
	geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			map.setCenter(results[0].geometry.location);
			marker = new google.maps.Marker({
				map: map,
				position: results[0].geometry.location,
				title: address
			});

			var tractInput = $("#census-tract");
			var url = $.trim(tractInput.attr("data-url")) + results[0].geometry.location.jb + "/" + results[0].geometry.location.kb;
			$.getJSON(url, function(json) {
				if (json.status.toLowerCase() == "ok") {
					input.data("location-json", $.toJSON(json));
				}
			});
		}
	});
});

// retrieve population
$("#get-population").click(function() {
	var a = $(this);
	a.button("loading");

	var url = a.attr("data-url");
	$.post(url, {
		"census-tract": $("#census-tract").data("location-json"),
		"market-area": $("#market-area").data("location-json"),
		"expanded-area": $("#expanded-area").data("location-json")
	}, function(json) {
		a.button("reset");
		$.each(json, function(type) {
			$.each(this, function(group) {
				$("td[data-key=" + type + "_" + group + "]").text(this);
			});
		});
	}, "json");
});

// form quick save
$("#quick-save").click(function() {
	var button = $(this);
	var form = $("form#project-editor");
	var alert = button.next(".label");

	button.button("loading");
	form.ajaxSubmit({
		dataType: "json",
		success: function(json) {
			alert.stop(true, true).fadeIn().text(json.text).delay(4000).fadeOut();
			button.button("reset");
		}
	});
});