"use strict";
setTimeout(function(){
        (function($) {
            "use strict";
            // Single Search Select
            $(".js-example-basic-single").select2();
            $(".js-example-disabled-results").select2();

            // Multi Select
            $(".js-example-basic-multiple").select2();

            // With Placeholder
            $(".js-example-placeholder-multiple").select2({

                placeholder: "Click vào để chọn!"
            });
            //Limited Numbers
            $(".js-example-basic-multiple-limit").select2({
                maximumSelectionLength: 2
            });

            //RTL Suppoort
            $(".js-example-rtl").select2({
                dir: "rtl"
            });
            // Responsive width Search Select
            $(".js-example-basic-hide-search").select2({
                minimumResultsForSearch: Infinity
            });
            $(".js-example-disabled").select2({
                disabled: true
            });
            $(".js-programmatic-enable").on("click", function() {
                $(".js-example-disabled").prop("disabled", false);
            });
            $(".js-programmatic-disable").on("click", function() {
                $(".js-example-disabled").prop("disabled", true);
            });
            $('#mySelect2').select2({
                dropdownParent: $('#add_new_teacher'),
                allowClear: true,
                placeholder: "Select your subject"
            });
            $("#mySelect2").select2("val", "");
            $("#p-p_class,#group_class").select2();

            $('#p-p_class,#group_class').select2({
                dropdownParent: $('#add_new_teaching_recording')
            });
            $('#pick_teacher').select2({
                dropdownParent: $('#modal_them-giao-vien')
            });
            $('#get_id_packet').select2({
                dropdownParent: $('#modal_them-giao-vien')
            });
            $('#pick_student').select2({
                dropdownParent: $('#transfer_money')
            });
        })(jQuery);
    }
    ,350);
