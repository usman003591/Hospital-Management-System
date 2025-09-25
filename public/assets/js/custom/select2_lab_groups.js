// Class definition
var KTSelect2 = function() {
	// Private functions
	var demos = function() {
        // basic
		$('#select2investigations').select2({
			placeholder: "Select an investigation"
		});

        $('#subSymptomSelect').select2({
			placeholder: "Select a sub symptom"
		});

        $('#kt_select2_2').select2({
			placeholder: "Select a doctor"
		});

        $('#subSymptomSelect').select2({
			placeholder: "Select a sub symptom"
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
