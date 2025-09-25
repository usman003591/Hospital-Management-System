<script>
    $(document).ready(function () {
        function toggleFollowUpDiv() {
            if ($('#selectDisposalVal').val() === 'follow_up') {
                $('#followup_div').show();
                if (!$('#disposal_type_value').data('datepicker')) {
                    new AirDatepicker('#disposal_type_value', {
                        timepicker: true,
                        dateFormat: 'dd/MM/yyyy',
                        autoClose: true,
                        minDate: new Date(),
                        maxDate: new Date(2200, 0, 1),
                        locale: {
                            days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                            daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                            daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                            months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                            monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            today: 'Today',
                            clear: 'Clear',
                            timeFormat: 'hh:mm AA',
                            firstDay: 0
                        }
                    });
                }

                let existingValue = "{{ isset($CdDisposalData) && $CdDisposalData->disposal_type === 'follow_up' ? $CdDisposalData->disposal_type_value : '' }}";

                if (existingValue && !$('#disposal_type_value').val()) {
                    $('#disposal_type_value').val(existingValue);
                }
            } else {
                $('#followup_div').hide();
                $('#disposal_type_value').val('');
            }
        }

        $('#selectDisposalVal').on('change', toggleFollowUpDiv);


        toggleFollowUpDiv();
    });
</script>

<script>
    $(document).ready(function () {

            $(".disposal-dropdown-div").hide();

            $('.selectDisposalVal').on('change', function () {
                var disposal_type = this.value;

                if (disposal_type == 'referred_to_hospital' ||
                    disposal_type == 'referred_to_specialist' ||
                    disposal_type == 'referred_to_department') {

                    $(".disposal-dropdown-div").show().html('');

                    $.ajax({
                        url: "{{ route('fetch_disposal_data') }}",
                        type: "GET",
                        data: {
                            disposal_type: disposal_type,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function (result) {
                            console.log(result);
                            $('.disposal-dropdown-div').html(result.html);
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                } else {
                    $(".disposal-dropdown-div").hide();
                }
            });

        });

        $(document).ready(function() {

            const urlParams = new URLSearchParams(window.location.search);
            const myParam = urlParams.get('tabName');

            if (myParam == 'brief_history') {

                var $li = $('#kt_vtab_pane_4_link');
                var $di = $('#kt_vtab_pane_4');

                $li.removeClass('active');
                $di.removeClass('active');
                $di.removeClass('show');

                var $nli = $('#kt_vtab_pane_6_link');
                var $ndi = $('#kt_vtab_pane_6');

                $nli.addClass('active');
                $ndi.addClass('active');
                $ndi.addClass('show');

            }

            if (myParam == 'complaints') {

                var $nli = $('#kt_vtab_pane_4_link');
                var $ndi = $('#kt_vtab_pane_4');

                $nli.addClass('active');
                $ndi.addClass('active');
                $ndi.addClass('show');
            }

            if (myParam == 'vitals') {

                var $li = $('#kt_vtab_pane_4_link');
                var $di = $('#kt_vtab_pane_4');

                $li.removeClass('active');
                $di.removeClass('active');
                $di.removeClass('show');

                var $nli = $('#kt_vtab_pane_5_link');
                var $ndi = $('#kt_vtab_pane_5');

                $nli.addClass('active');
                $ndi.addClass('active');
                $ndi.addClass('show');

            }

            if (myParam == 'diagnosis') {

                var $li = $('#kt_vtab_pane_4_link');
                var $di = $('#kt_vtab_pane_4');

                $li.removeClass('active');
                $di.removeClass('active');
                $di.removeClass('show');

                var $nli = $('#kt_vtab_pane_10_link');
                var $ndi = $('#kt_vtab_pane_10');

                $nli.addClass('active');
                $ndi.addClass('active');
                $ndi.addClass('show');

            }
            if (myParam == 'procedure') {

                var $li = $('#kt_vtab_pane_4_link');
                var $di = $('#kt_vtab_pane_4');

                $li.removeClass('active');
                $di.removeClass('active');
                $di.removeClass('show');

                var $nli = $('#kt_vtab_pane_14_link');
                var $ndi = $('#kt_vtab_pane_14');

                $nli.addClass('active');
                $ndi.addClass('active');
                $ndi.addClass('show');

            }

            if (myParam == 'gpe') {
                var $li = $('#kt_vtab_pane_4_link');
                var $di = $('#kt_vtab_pane_4');

                $li.removeClass('active');
                $di.removeClass('active');
                $di.removeClass('show');

                var $nli = $('#kt_vtab_pane_7_link');
                var $ndi = $('#kt_vtab_pane_7');

                $nli.addClass('active');
                $ndi.addClass('active');
                $ndi.addClass('show');
            }

            if (myParam == 'spe') {
                var $li = $('#kt_vtab_pane_4_link');
                var $di = $('#kt_vtab_pane_4');

                $li.removeClass('active');
                $di.removeClass('active');
                $di.removeClass('show');

                var $nli = $('#kt_vtab_pane_8_link');
                var $ndi = $('#kt_vtab_pane_8');

                $nli.addClass('active');
                $ndi.addClass('active');
                $ndi.addClass('show');
            }

            if (myParam == 'investigations') {
                var $li = $('#kt_vtab_pane_4_link');
                var $di = $('#kt_vtab_pane_4');

                $li.removeClass('active');
                $di.removeClass('active');
                $di.removeClass('show');

                var $nli = $('#kt_vtab_pane_9_link');
                var $ndi = $('#kt_vtab_pane_9');

                $nli.addClass('active');
                $ndi.addClass('active');
                $ndi.addClass('show');
            }


            if (myParam == 'treatment') {
                var $li = $('#kt_vtab_pane_4_link');
                var $di = $('#kt_vtab_pane_4');

                $li.removeClass('active');
                $di.removeClass('active');
                $di.removeClass('show');

                var $nli = $('#kt_vtab_pane_11_link');
                var $ndi = $('#kt_vtab_pane_11');

                $nli.addClass('active');
                $ndi.addClass('active');
                $ndi.addClass('show');
            }


            if (myParam == 'disposal') {
                var $li = $('#kt_vtab_pane_4_link');
                var $di = $('#kt_vtab_pane_4');

                $li.removeClass('active');
                $di.removeClass('active');
                $di.removeClass('show');

                var $nli = $('#kt_vtab_pane_12_link');
                var $ndi = $('#kt_vtab_pane_12');

                $nli.addClass('active');
                $ndi.addClass('active');
                $ndi.addClass('show');
            }

            // if (myParam == 'snapshot') {
            //     var $li = $('#kt_vtab_pane_4_link');
            //     var $di = $('#kt_vtab_pane_4');

            //     $li.removeClass('active');
            //     $di.removeClass('active');
            //     $di.removeClass('show');

            //     var $nli = $('#kt_vtab_pane_13_link');
            //     var $ndi = $('#kt_vtab_pane_13');

            //     $nli.addClass('active');
            //     $ndi.addClass('active');
            //     $ndi.addClass('show');
            // }


        });
</script>
<script>
    var KTLayoutStretchedCard = function() {
            // Private properties
            var _element;

            // Private functions
            var _init = function() {
                var scroll = KTUtil.find(_element, '.card-scroll');
                var cardBody = KTUtil.find(_element, '.card-body');
                var cardHeader = KTUtil.find(_element, '.card-header');

                var height = KTLayoutContent.getHeight();

                height = height - parseInt(KTUtil.actualHeight(cardHeader));

                height = height - parseInt(KTUtil.css(_element, 'marginTop')) - parseInt(KTUtil.css(_element,
                    'marginBottom'));
                height = height - parseInt(KTUtil.css(_element, 'paddingTop')) - parseInt(KTUtil.css(_element,
                    'paddingBottom'));

                height = height - parseInt(KTUtil.css(cardBody, 'paddingTop')) - parseInt(KTUtil.css(cardBody,
                    'paddingBottom'));
                height = height - parseInt(KTUtil.css(cardBody, 'marginTop')) - parseInt(KTUtil.css(cardBody,
                    'marginBottom'));

                height = height - 3;

                KTUtil.css(scroll, 'height', height + 'px');
            }

            // Public methods
            return {
                init: function(id) {
                    _element = KTUtil.getById(id);

                    if (!_element) {
                        return;
                    }

                    // Initialize
                    _init();

                    // Re-calculate on window resize
                    KTUtil.addResizeHandler(function() {
                        _init();
                    });
                },

                update: function() {
                    _init();
                }
            };
        }();

        // Webpack support
        if (typeof module !== 'undefined') {
            module.exports = KTLayoutStretchedCard;
        }
</script>
<script>
    $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'Enter Brief History',
                tabsize: 2,
                height: 100
            });
        });


        $(document).ready(function() {
            $(document).on('change', '.selectSymptom', function() {
                var symptomId = $(this).val();
                var $sub_symptom_dropdown = $(this).closest('.repeater-row').find('.selectSubSymptom');

                $sub_symptom_dropdown.empty().append('<option value="">Select a Sub Symptom</option>')
                    .select2();
                if (symptomId) {
                    $.ajax({
                        url: '/api/fetch-complaints/' + symptomId,
                        type: 'GET',
                        success: function(sub_symptoms) {
                            console.log(sub_symptoms);
                            $.each(sub_symptoms, function(index, symptom) {
                                $sub_symptom_dropdown.append('<option value="' + symptom
                                        .id + '">' + symptom.name + '</option>')
                                    .select2();
                            });
                            $sub_symptom_dropdown.select2({
                                    placeholder: "Select Additional Symptoms",
                                    tags: true,
                                    multiple: true,
                                    createTag: function (params) {
                                        const term = $.trim(params.term).toLowerCase();
                                        let isDuplicate = false;

                                        // Loop over existing options and compare text
                                        $sub_symptom_dropdown.find('option').each(function () {
                                            if ($.trim($(this).text()).toLowerCase() === term) {
                                                isDuplicate = true;
                                                return false; // exit loop early
                                            }
                                        });

                                        // If it matches an existing option, do not show "new tag"
                                        if (isDuplicate) {
                                            return null;
                                        }

                                        // Otherwise, return the tag object
                                        return {
                                            id: params.term,
                                            text: params.term,
                                            newTag: true
                                        };
                                    }
                                });
                        },
                        error: function() {
                           alert('Unable to fetch sub symptoms');
                       }
                    });
                }




            });
        });

        $('#kt_docs_repeater_advanced_complaints').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {

                $(this).slideDown();
                $(this).find('[data-kt-repeater="symptom_select_2"]').select2({
                    placeholder: "Select a Symptom"
                });
                $(this).find('[data-kt-repeater="sub_symptom_select_2"]').select2({
                    placeholder: "Select a Sub Symptom",
                    tags: true,
                    multiple: true,
                    createTag: function (params) {
                    const term = $.trim(params.term).toLowerCase();
                    let isDuplicate = false;

                    // Loop over existing options and compare text
                    $('[data-kt-repeater="procedure_select_2"] option').each(function () {
                        if ($.trim($(this).text()).toLowerCase() === term) {
                            isDuplicate = true;
                            return false; // exit loop early
                        }
                    });

                    // If it matches an existing option, do not show "new tag"
                    if (isDuplicate) {
                        return null;
                    }

                    // Otherwise, return the tag object
                    return {
                        id: params.term,
                        text: params.term,
                        newTag: true
                    };
                }

                });
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                $('[data-kt-repeater="symptom_select_2"]').select2({
                    placeholder: "Select a Symptom"
                });
                $('[data-kt-repeater="sub_symptom_select_2"]').select2({
                    placeholder: "Select a Sub Symptom",
                    tags: true,
                    multiple: true,
                    createTag: function (params) {
                    const term = $.trim(params.term).toLowerCase();
                    let isDuplicate = false;

                    // Loop over existing options and compare text
                    $('[data-kt-repeater="procedure_select_2"] option').each(function () {
                        if ($.trim($(this).text()).toLowerCase() === term) {
                            isDuplicate = true;
                            return false; // exit loop early
                        }
                    });

                    // If it matches an existing option, do not show "new tag"
                    if (isDuplicate) {
                        return null;
                    }

                    // Otherwise, return the tag object
                    return {
                        id: params.term,
                        text: params.term,
                        newTag: true
                    };
                }
                });
            }
        });
</script>
<script>
    $(document).ready(function() {
            $(document).on('change', '.selectGPE', function() {
                var id = $(this).val();
                var $sub_dropdown = $(this).closest('.repeater-row-gpe').find('.selectSubGPE');
                $sub_dropdown.empty().append('<option value="">Select Addtional GPEs</option>').select2();
                if (id) {
                    $.ajax({
                        url: '/api/fetch-general-physical-examinations/' + id,
                        type: 'GET',
                        success: function(data) {
                            console.log(data);
                            $.each(data, function(index, item) {
                                $sub_dropdown.append('<option value="' + item.id +
                                    '">' + item.name + '</option>').select2();
                                });
                                $sub_dropdown.select2({
                                    placeholder: "Select Addtional GPEs",
                                    tags: true,
                                    multiple: true,
                                    createTag: function (params) {
                                        const term = $.trim(params.term).toLowerCase();
                                        let isDuplicate = false;

                                        // Loop over existing options and compare text
                                        $sub_dropdown.find('option').each(function () {
                                            if ($.trim($(this).text()).toLowerCase() === term) {
                                                isDuplicate = true;
                                                return false; // exit loop early
                                            }
                                        });

                                        // If it matches an existing option, do not show "new tag"
                                        if (isDuplicate) {
                                            return null;
                                        }

                                        // Otherwise, return the tag object
                                        return {
                                            id: params.term,
                                            text: params.term,
                                            newTag: true
                                        };
                                    }
                                });
                        },
                       error: function(data) {
                           console.log(data);
                           alert('Unable to fetch general physical examinations');
                       }
                    });
                }
            });
        });

        $('#kt_docs_repeater_advanced_gpe').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {

                $(this).slideDown();
                $(this).find('[data-kt-repeater="gpe_select_2"]').select2({
                    placeholder: "Select GPE"
                });
                $(this).find('[data-kt-repeater="sub_gpe_select_2"]').select2({
                    placeholder: "Select Addtional GPE",
                });
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                $('[data-kt-repeater="gpe_select_2"]').select2({
                    placeholder: "Select GPE"
                });
                $('[data-kt-repeater="sub_gpe_select_2"]').select2({
                    placeholder: "Select Addtional GPE",
                });
            }
        });
</script>
<script>
    $(document).ready(function() {
            $(document).on('change', '.selectSPE', function() {
                var id = $(this).val();
                var $sub_dropdown = $(this).closest('.repeater-row-spes').find('.selectSubSPE');
                $sub_dropdown.empty().append('<option value="">Select Addtional SPEs </option>').select2();
                if (id) {
                    $.ajax({
                        url: '/api/fetch-systematic-physical-examinations/' + id,
                        type: 'GET',
                        success: function(data) {
                            console.log(data);
                            $.each(data, function(index, item) {
                                $sub_dropdown.append('<option value="' + item.id +
                                    '">' + item.name + '</option>').select2();
                            });
                            $sub_dropdown.select2({
                                    placeholder: "Select Addtional SPEs",
                                    tags: true,
                                    multiple: true,
                                    createTag: function (params) {
                                        const term = $.trim(params.term).toLowerCase();
                                        let isDuplicate = false;

                                        // Loop over existing options and compare text
                                        $sub_dropdown.find('option').each(function () {
                                            if ($.trim($(this).text()).toLowerCase() === term) {
                                                isDuplicate = true;
                                                return false; // exit loop early
                                            }
                                        });

                                        // If it matches an existing option, do not show "new tag"
                                        if (isDuplicate) {
                                            return null;
                                        }

                                        // Otherwise, return the tag object
                                        return {
                                            id: params.term,
                                            text: params.term,
                                            newTag: true
                                        };
                                    }
                                });
                        },
                       error: function(data) {
                           console.log(data);
                           alert('Unable to fetch sub systematic physical examinations');
                       }
                    });
                }
            });
        });

        $('#kt_docs_repeater_advanced_spe').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {

                $(this).slideDown();
                $(this).find('[data-kt-repeater="spe_select_2"]').select2({
                    placeholder: "Select SPE"
                });
                $(this).find('[data-kt-repeater="sub_spe_select_2"]').select2({
                    placeholder: "Select Addtional SPE"
                });
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                $('[data-kt-repeater="spe_select_2"]').select2({
                    placeholder: "Select SPE"
                });
                $('[data-kt-repeater="sub_spe_select_2"]').select2({
                    placeholder: "Select Addtional SPE"
                });
            }
        });
</script>

<script>
    $(document).ready(function() {
            $('.selectDiagnosis').select2({
                tags: true,
                placeholder: "Select Diagnosis",
                // createTag: function (params) {
                //     const term = $.trim(params.term).toLowerCase();
                //     let isDuplicate = false;

                //     // Loop over existing options and compare text
                //     $('[data-kt-repeater="diagnosis_select_2"] option').each(function () {
                //         if ($.trim($(this).text()).toLowerCase() === term) {
                //             isDuplicate = true;
                //             return false; // exit loop early
                //         }
                //     });

                //     // If it matches an existing option, do not show "new tag"
                //     if (isDuplicate) {
                //         return null;
                //     }

                //     // Otherwise, return the tag object
                //     return {
                //         id: params.term,
                //         text: params.term,
                //         newTag: true
                //     };
                // },
                ajax: {
                    url: "{{ route('search.diagnosis') }}",
                    dataType: 'json',
                    delay: 50,
                    data: function (params) {
                        return {
                            q: params.term // Search term
                        };
                    },
                    processResults: function (data, params) {
                        const term = params.term?.toLowerCase();
                        const mapped = data.map(dia => ({
                            id: dia.id,
                            text: dia.display_name
                        }));

                        const exactMatch = mapped.some(item => item.text.toLowerCase() === term);

                        // If no exact match, push new tag manually
                        if (term && !exactMatch) {
                            mapped.push({
                                id: params.term,
                                text: params.term,
                                newTag: true
                            });
                        }

                        return {
                            results: mapped
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2 // Minimum characters to trigger search
            });
        });

        $('#kt_docs_repeater_advanced_diagnosis').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {

                $(this).slideDown();
                $(this).find('[data-kt-repeater="diagnosis_select_2"]').select2({
                    placeholder: "Select Diagnosis",
                    tags: true,
                    ajax: {
                        url: "{{ route('search.diagnosis') }}",
                        dataType: 'json',
                        delay: 50,
                        data: function (params) {
                            return {
                                q: params.term
                            };
                        },
                        processResults: function (data, params) {
                            const term = params.term?.toLowerCase();
                            const mapped = data.map(dia => ({
                                id: dia.id,
                                text: dia.display_name
                            }));

                            const exactMatch = mapped.some(item => item.text.toLowerCase() === term);

                            // If no exact match, push new tag manually
                            if (term && !exactMatch) {
                                mapped.push({
                                    id: params.term,
                                    text: params.term,
                                    newTag: true
                                });
                            }

                            return {
                                results: mapped
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 1
                });

                $('[data-kt-repeater="diagnosis_categories_select_2"]').select2({
                    placeholder: "Select Diagnosis Categories"
                });

            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                $('[data-kt-repeater="diagnosis_select_2"]').select2({
                    placeholder: "Select Diagnosis",
                    tags: true,
                });

                $('[data-kt-repeater="diagnosis_categories_select_2"]').select2({
                    placeholder: "Select Diagnosis Categories"
                });

            }
        });
</script>
<script>
    $(document).ready(function() {
            $(document).on('change', '.selectProcedure', function() {
                var id = $(this).val();
                // var $sub_dropdown = $(this).closest('.repeater-row-procedure').find('.selectSubProcedure');
                // $sub_dropdown.empty().append('<option value="">Select Addtional Procedure </option>')
                //     .select2();

                if (id) {
                    $.ajax({
                        url: '/api/fetch-procedure/' + id,
                        type: 'GET',
                        success: function(data) {
                            console.log(data);
                            $.each(data, function(index, item) {
                                $sub_dropdown.append('<option value="' + item.id +
                                    '">' + item.name + '</option>').select2();
                            });
                        },
                        // error: function(data) {
                        //     console.log(data);
                        //     alert('Unable to fetch sub Procedure');
                        // }
                    });
                }
            });
        });

        $('#kt_docs_repeater_advanced_procedure').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {

                $(this).slideDown();
                $(this).find('[data-kt-repeater="procedure_select_2"]').select2({
                    tags: true,
                    placeholder: "Select procedure",
                    createTag: function (params) {
                    const term = $.trim(params.term).toLowerCase();
                    let isDuplicate = false;

                    // Loop over existing options and compare text
                    $('[data-kt-repeater="procedure_select_2"] option').each(function () {
                        if ($.trim($(this).text()).toLowerCase() === term) {
                            isDuplicate = true;
                            return false; // exit loop early
                        }
                    });

                    // If it matches an existing option, do not show "new tag"
                    if (isDuplicate) {
                        return null;
                    }

                    // Otherwise, return the tag object
                    return {
                        id: params.term,
                        text: params.term,
                        newTag: true
                    };
                }
                });
                // $(this).find('[data-kt-repeater="sub_procedure_select_2"]').select2({
                //     placeholder: "Select Addtional procedure"
                // });
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function () {
            $('[data-kt-repeater="procedure_select_2"]').select2({
                tags: true,
                placeholder: "Select procedure",
                createTag: function (params) {
                    const term = $.trim(params.term).toLowerCase();
                    let isDuplicate = false;

                    // Loop over existing options and compare text
                    $('[data-kt-repeater="procedure_select_2"] option').each(function () {
                        if ($.trim($(this).text()).toLowerCase() === term) {
                            isDuplicate = true;
                            return false; // exit loop early
                        }
                    });

                    // If it matches an existing option, do not show "new tag"
                    if (isDuplicate) {
                        return null;
                    }

                    // Otherwise, return the tag object
                    return {
                        id: params.term,
                        text: params.term,
                        newTag: true
                    };
                }
            });
}
        });
</script>

<script>
    $('#kt_docs_repeater_advanced_radiology').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();
                $(this).find('[data-kt-repeater="radiology_select_2"]').select2({
                    placeholder: "Select Radiology test",
                    tags: true,
                    createTag: function (params) {
                        const term = $.trim(params.term).toLowerCase();
                        let isDuplicate = false;

                        // Loop over existing options and compare text
                        $('[data-kt-repeater="radiology_select_2"] option').each(function () {
                            if ($.trim($(this).text()).toLowerCase() === term) {
                                isDuplicate = true;
                                return false; // exit loop early
                            }
                        });

                        // If it matches an existing option, do not show "new tag"
                        if (isDuplicate) {
                            return null;
                        }

                        // Otherwise, return the tag object
                        return {
                            id: params.term,
                            text: params.term,
                            newTag: true
                        };
                    }
                });
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                $('[data-kt-repeater="radiology_select_2"]').select2({
                    placeholder: "Select Radiology test",
                    tags: true,
                    createTag: function (params) {
                        const term = $.trim(params.term).toLowerCase();
                        let isDuplicate = false;

                        // Loop over existing options and compare text
                        $('[data-kt-repeater="radiology_select_2"] option').each(function () {
                            if ($.trim($(this).text()).toLowerCase() === term) {
                                isDuplicate = true;
                                return false; // exit loop early
                            }
                        });

                        // If it matches an existing option, do not show "new tag"
                        if (isDuplicate) {
                            return null;
                        }

                        // Otherwise, return the tag object
                        return {
                            id: params.term,
                            text: params.term,
                            newTag: true
                        };
                    }
                });
            }
        });

        $('#kt_docs_repeater_advanced_pathology').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();
                $(this).find('[data-kt-repeater="pathology_select_2"]').select2({
                    placeholder: "Select Pathology test",
                    tags: true,
                    createTag: function (params) {
                        const term = $.trim(params.term).toLowerCase();
                        let isDuplicate = false;

                        // Loop over existing options and compare text
                        $('[data-kt-repeater="pathology_select_2"] option').each(function () {
                            if ($.trim($(this).text()).toLowerCase() === term) {
                                isDuplicate = true;
                                return false; // exit loop early
                            }
                        });

                        // If it matches an existing option, do not show "new tag"
                        if (isDuplicate) {
                            return null;
                        }

                        // Otherwise, return the tag object
                        return {
                            id: params.term,
                            text: params.term,
                            newTag: true
                        };
                    }
                });
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                $('[data-kt-repeater="pathology_select_2"]').select2({
                    placeholder: "Select Pathology test",
                    tags: true,
                    createTag: function (params) {
                        const term = $.trim(params.term).toLowerCase();
                        let isDuplicate = false;

                        // Loop over existing options and compare text
                        $('[data-kt-repeater="pathology_select_2"] option').each(function () {
                            if ($.trim($(this).text()).toLowerCase() === term) {
                                isDuplicate = true;
                                return false; // exit loop early
                            }
                        });

                        // If it matches an existing option, do not show "new tag"
                        if (isDuplicate) {
                            return null;
                        }

                        // Otherwise, return the tag object
                        return {
                            id: params.term,
                            text: params.term,
                            newTag: true
                        };
                    }
                });
            }
        });


        $('#kt_docs_repeater_advanced_rehablitation').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();
                $(this).find('[data-kt-repeater="rehablitation_select_2"]').select2({
                    placeholder: "Select Rehablitation test",
                    tags: true,
                    createTag: function (params) {
                        const term = $.trim(params.term).toLowerCase();
                        let isDuplicate = false;

                        // Loop over existing options and compare text
                        $('[data-kt-repeater="rehablitation_select_2"] option').each(function () {
                            if ($.trim($(this).text()).toLowerCase() === term) {
                                isDuplicate = true;
                                return false; // exit loop early
                            }
                        });

                        // If it matches an existing option, do not show "new tag"
                        if (isDuplicate) {
                            return null;
                        }

                        // Otherwise, return the tag object
                        return {
                            id: params.term,
                            text: params.term,
                            newTag: true
                        };
                    }
                });
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                $('[data-kt-repeater="rehablitation_select_2"]').select2({
                    placeholder: "Select Rehablitation test",
                    tags: true,
                    createTag: function (params) {
                        const term = $.trim(params.term).toLowerCase();
                        let isDuplicate = false;

                        // Loop over existing options and compare text
                        $('[data-kt-repeater="rehablitation_select_2"] option').each(function () {
                            if ($.trim($(this).text()).toLowerCase() === term) {
                                isDuplicate = true;
                                return false; // exit loop early
                            }
                        });

                        // If it matches an existing option, do not show "new tag"
                        if (isDuplicate) {
                            return null;
                        }

                        // Otherwise, return the tag object
                        return {
                            id: params.term,
                            text: params.term,
                            newTag: true
                        };
                    }
                });
            }
        });


        function styleOption(state) {
            if (!state.id) return state.text;   // placeholder

            const isInHouse = $(state.element).data('is-in-house') == 1;
            const $node     = $('<span>', { text: state.text });

            if (isInHouse) $node.addClass('is-in-house');
            return $node;
        }

        $('#kt_docs_repeater_advanced_treatment').repeater({
            initEmpty: false,
            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();
                $(this).find('[data-kt-repeater="medicine_select_2"]').select2({
                    placeholder: "Select Medicine",
                    tags: true,
                    ajax: {
                        url: "{{ route('search.medicines') }}",
                        dataType: 'json',
                        delay: 50,
                        data: function (params) {
                            return {
                                q: params.term
                            };
                        },
                        processResults: function (data, params) {
                            const term = params.term?.toLowerCase();
                            const mapped = data.map(dia => ({
                                id: dia.id,
                                text: dia.display_name
                            }));
                            const exactMatch = mapped.some(item => item.text.toLowerCase() === term);
                            // If no exact match, push new tag manually
                            if (term && !exactMatch) {
                                mapped.push({
                                    id: params.term,
                                    text: params.term,
                                    newTag: true
                                });
                            }

                            return {
                                results: mapped
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 2
                });

                $(this).find('[data-kt-repeater="dosage_select_2"]').select2({
                    placeholder: "Select Dosage"
                });

                $(this).find('[data-kt-repeater="duration_select_2"]').select2({
                    placeholder: "Select Duration"
                });

                $(this).find('[data-kt-repeater="interval_select_2"]').select2({
                    placeholder: "Select Dosage Interval"
                });

                $(this).find('[data-kt-repeater="form_select_2"]').select2({
                    placeholder: "Select medicine form"
                });
                $(this).find('[data-kt-repeater="route_select_2"]').select2({
                    placeholder: "Select medicine route"
                });

                $(this).find('[data-kt-repeater="frequency_select_2"]').select2({
                    placeholder: "Select medicine Frequency"
                });
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                $('[data-kt-repeater="medicine_select_2"]').select2({
                    placeholder: "Select Medicine",
                    tags: true,
                    ajax: {
                        url: "{{ route('search.medicines') }}",
                        dataType: 'json',
                        delay: 50,
                        data: function (params) {
                            return {
                                q: params.term
                            };
                        },
                        processResults: function (data, params) {
                            const term = params.term?.toLowerCase();
                            const mapped = data.map(dia => ({
                                id: dia.id,
                                text: dia.display_name
                            }));
                            const exactMatch = mapped.some(item => item.text.toLowerCase() === term);
                            // If no exact match, push new tag manually
                            if (term && !exactMatch) {
                                mapped.push({
                                    id: params.term,
                                    text: params.term,
                                    newTag: true
                                });
                            }

                            return {
                                results: mapped
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 2
                });

                $('[data-kt-repeater="dosage_select_2"]').select2({
                    placeholder: "Select Dosage"
                });

                $('[data-kt-repeater="duration_select_2"]').select2({
                    placeholder: "Select Duration"
                });

                $('[data-kt-repeater="interval_select_2"]').select2({
                    placeholder: "Select Dosage Interval"
                });

                $('[data-kt-repeater="form_select_2"]').select2({
                    placeholder: "Select medicine form"
                });
                $('[data-kt-repeater="route_select_2"]').select2({
                    placeholder: "Select medicine route"
                });

                $('[data-kt-repeater="frequency_select_2"]').select2({
                    placeholder: "Select medicine Frequency"
                });

            }
        });
</script>

<script>
    $(document).ready(function() {

            // document.querySelector('#kt_check_indeterminate_1').indeterminate = true;

            $(document).on('click', '.delete-{{ $page }}', function() {
                $('#kt_modal_delete_{{ $page }}_submit').attr('href', $(this).attr('href'));
                $('#kt_modal_delete_{{ $page }}').modal('show');
                return false;
            });

            $(document).on('click', '#kt_modal_delete_{{ $page }}_close', function() {
                $('#kt_modal_delete_{{ $page }}').modal('hide');
                return false;
            });

            $(document).on('click', '#kt_modal_delete_{{ $page }}_cancel', function() {
                $('#kt_modal_delete_{{ $page }}').modal('hide');
                return false;
            });


            $(document).on('click', '#kt_modal_delete_{{ $page }}_submit', function(event) {
                event.preventDefault();
                getURL = $(this).attr('href');
                $.ajax({
                    url: getURL,
                    method: 'delete',
                    success: function(result) {
                        $('#kt_modal_delete_{{ $page }}').modal('hide');
                        show_message('success', result.message);
                        setTimeout(function() {
                            window.location.href = SITEURL + "/{{ $page }}";
                        }, 3000);

                    },
                });
            });


        });
</script>

<style>
    .select2-results .select2-disabled,
    .select2-results__option[aria-disabled=true] {
        display: none;
    }
</style>
<script>
    // document.addEventListener('DOMContentLoaded', function () {
        // Get the saved date from the input
        const savedDateValue = document.getElementById('disposalDate').value;

        // Function to parse 'dd/MM/yyyy hh:mm A' into a JS Date object
        function parseSavedDate(dateStr) {
        if (!dateStr) return null;

        // Match format: "27/06/2025 15:30"
        const match = dateStr.match(/^(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})$/);
        if (!match) return null;

        const [, day, month, year, hourStr, minuteStr] = match;
        const hour = parseInt(hourStr, 10);
        const minute = parseInt(minuteStr, 10);

        return new Date(year, month - 1, day, hour, minute);
        }
    // });

    // Initialize AirDatepicker with defaultDate from input
    new AirDatepicker('#disposalDate', {
        dateFormat: 'dd/MM/yyyy',
        timepicker: true,
        autoClose: true,
        minDate: new Date(1900, 0, 1),
        maxDate: new Date(2200, 0, 1),
        selectedDates: [parseSavedDate(savedDateValue)],
        locale: {
            days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            today: 'Today',
            clear: 'Clear',
            timeFormat: 'HH:mm',
            firstDay: 0
        }
    });
</script>
{{-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        var appointmentModal = document.getElementById('UploadManualPresc');
        appointmentModal.addEventListener('hidden.bs.modal', function () {
            this.querySelector('form').reset();
        });
    });
</script> --}}
