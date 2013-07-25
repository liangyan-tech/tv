$(function() {
	$.ajaxSetup({ cache: false });
	
	$("[href=#]").click(function() { return false; });
	
	// fades out flash message automatically
	// $(".navbar .alert").delay(10000).fadeOut();
	
	// tooltips and popovers
	$("[data-toggle=popover]").popover();
	$("[data-toggle=tooltip]").tooltip();
	
	// triggers dropdowns
	$('.dropdown-toggle').dropdown();

	// datepicker
	if ( $('[data-toggle=datepicker]').length ) {
		$('[data-toggle=datepicker]').datepicker({
			format: 'yyyy-mm-dd'
		});
	}
	
	// ajax modal
	$("body").on("click", "a[data-toggle=modal]", function() {
		// hides all popovers and tooltips
		$("[rel=popover]").popover("hide");
		$("[rel=tooltip]").tooltip("hide");
		
		var a = $(this);
		var modal = $(a.attr("data-target"));
		var url = a.attr("href");
		
		modal.addClass("loading").load(url, function() {
			$(this).removeClass("loading");
			$("body").trigger("rebind");
		});
	})

	// ajax pagination more
	$("body").on("click", ".pagination-more a", function() {
		var a = $(this);
		if (a.hasClass("disabled") || a.is("[disabled]")) return false;	
		
		$(".pagination-more .btn[rel=tooltip]").tooltip("hide");
		a.removeClass().addClass(a.attr("data-static-classes"));
		
		var url = $(this).attr("href");
		$.get(url, function(data) {
			// getting html chunks for tbody and .pagination-more respectively
			var html = $('<div />').html(data);
			var content = html.find('tbody.ajax-content').html();
			var paginator = html.find('.pagination-more').html();
			
			$("tbody.ajax-content").append(content);
			$(".pagination-more").html(paginator);
			
			$("body").trigger("rebind");
		});
		
		return false;
	});
	
// Bootstrap button effects
	$(":submit").button();
	$("body").on("click", "[data-loading-text][data-prevent-default!=button]", function() {
		var button = $(this);
		var form = button.parents("form");
		if (form.length) {
			if ( !form.get(0).checkValidity() ) return;
		}
		
		button.button("loading");
		
		if (button.attr("data-loading-duration")) {
			setTimeout(function() {
				button.button("reset");
			}, button.attr("data-loading-duration"));
		}
	});
	
	// trims input
	$("body").on("change", "input[type=text]", function() {
		var input = $(this);
		input.val( $.trim(input.val()) );
	});
});