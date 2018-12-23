(function($) {
	$(document).ready(function() {
		var $dateReport = $("input#date");
		
		$.getScript("assets/js/setup/datePickerSetup.js")
			.done(function(script, status) {
				$dateReport.val(currentSlashDate());
		});
		
		$dateReport.datepicker({
			minDate: new Date(2018, 1, 1),
			maxDate: new Date(2019, 0)
		});
	});
})(jQuery);