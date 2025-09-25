// Class definition
var KTSelect2 = function() {
	// Private functions
	var demos = function() {
        // basic
		$('#symptomSelect').select2({
			placeholder: "Select a Symptom"
		});

        $('#subSymptomSelect').select2({
			placeholder: "Select a Sub Symptom"
		});

        $('#kt_select2_2').select2({
			placeholder: "Select a Doctor"
		});

        $('#subSymptomSelect').select2({
			placeholder: "Select Sub Symptom"
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
