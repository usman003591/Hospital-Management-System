// Class definition
var KTSelect2 = function() {
	// Private functions
	var demos = function() {
        // basic
		$('#kt_select2_1').select2({
			placeholder: "Select a Patient"
		});

        $('#kt_select2_2').select2({
			placeholder: "Select a Doctor"
		});

        $('#kt_select2_3').select2({
			placeholder: "Select a Service Category"
		});


	}

	// Public functions
	return {
		init: function() {
			demos();
		}
	};
}();

// Initialization
jQuery(document).ready(function() {
	KTSelect2.init();
});
