$(document).ready(function(){
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    // Xử lý nút lưu tổng số giờ
    $('#total_hours').keypress(function (e) {
        if(e.which==13){
            var object_param={
                id_nkgd:$(this).attr("id_nkgd"),
                key:$(this).attr("key"),
                key_value:$(this).val()
            }
            $.ajax({
                type: "POST",
                url: rootUrl+'/edit',
                data: object_param,
                success: function (response) {
                    if(response.status == 'success'){
                        // $('#').append("<b>Appended text</b>");
                        // $('#luu_gio_messenge').fadeIn().text('Done!');
                        location.reload();
                    }
                }
            });
        }

    });
    $('.button__finish-subject').click(function(e){
        e.preventDefault();
        if(confirm("Thao tác này sẽ Ẩn/ Hiện môn học đã hoàng thành, và không làm mất dữ liệu")==true){
            var object_param={
                id_nkgd:$(this).attr("id_nkgd"),
                id_teacher:$(this).attr("id_teacher"),
                id_subject:$(this).attr("id_subject"),
                finish:$(this).attr("finish"),
            }
            $.ajax({
                type: "POST",
                url: rootUrl+'/detail/finish',
                data: object_param,
                success: function (response) {
                    if(response.status=='success'){
                        location.reload();
                    }else{
                        console.log(response);
                        alert('Có lỗi, liên hệ webadmin');
                    }
                }
            });
        }

    });
    /**
     * Xử lý Bảo lưu
     */
    // Nút bảo lưu gói giờ
    $('.button__resever').click(function () {
        var object_param={
            id_nkgd:$('[name="reserve_id_nkgd"]').val(),
            amount:$('[name="reserve_amountOfMonney"]').val(),
            hours:$('[name="reserve_timeLeft"]').val(),
            id_student:$('[name="reserve_id_student"]').val(),
        }
        $.ajax({
            type: "POST",
            url: rootUrl+'/detail/reserve/to_reserve',
            data: object_param,
            success: function (response) {
                if(response.status=='success'){
                   // $('#'+object_param.time).fadeOut();
                   location.reload();
                }
                if(response.status=='false'){
                    alert(response.messenger);
                }
            }
        });
    });
    // Đổi tiền từ bảo lưu sang giờ
    $('.from_revenue_to_hours').click(function () {
        var object_param={
            id_nkgd:$('#covert_id_nkgd').val(),
            id_student:$('#convert_id_student').val(),
            amountOfMoney:$('#so_tien_can_chuyen').val(),
            hours:$('#covert_so_gio').val(),
        }
        $.ajax({
            type: "POST",
            url: rootUrl+'/detail/reserve/to_hours',
            data: object_param,
            success: function (response) {
                if(response.status=='success'){
                   location.reload();
                }
                if(response.status=='false'){
                    alert(response.messenger);
                }
            }
        });
    });
    // Nut chuyển tiền bảo lưu sang học sinh khác
    $('.button___transfer_reserve').click(function (){
        var object_param={
            id_source_student:$('#transfer_id_source_student').val(),
            id_des_student:$('#transfer_id_des_student').val(),
            amountOfMoney:$('#transfer_amount_money').val()
        }
        $.ajax({
            type: "POST",
            url: rootUrl+'/detail/reserve/transfer',
            data: object_param,
            success: function (response) {
                if(response.status=='success'){
                   location.reload();
                }
                if(response.status=='false'){
                    alert(response.messenger);
                }
            }
        });
    });
    /**
     * Các thao tác xử lý trên buổi
     */
    //Xử lý nút thêm buổi
    $('.button__add-date').click(function () {
        var object_param={
            id_nkgd:$('[name=add_date_id_nkgd]').val(),
            id_teacher:$('[name=add_date_id_teacher]').val(),
            id_subject:$('[name=add_date_id_subject]').val(),
            id_student:$('[name=add_date_id_student]').val(),
            newdate:$('[name=add_date_newdate]').val(),
            starttime:$('[name=add_date_starttime]').val(),
            endtime:$('[name=add_date_endtime]').val(),
            note_them_ngay:$('[name=add_date_note]').val(),
        }
        $.ajax({
            type: "POST",
            url: rootUrl+'/detail/add/day',
            data: object_param,
            success: function (response) {
                if(response.status=='success'){
                   // $('#'+object_param.time).fadeOut();
                   location.reload();
                }
                if(response.status=='false'){
                    alert(response.messenger);
                }
            }
        });
    });
    $('.button__add-date-range').click(function () {
        var object_param={
            id_nkgd:$('[name=add_date_id_nkgd]').val(),
            id_teacher:$('[name=add_date_id_teacher]').val(),
            id_subject:$('[name=add_date_id_subject]').val(),
            id_student:$('[name=add_date_id_student]').val(),
            newdate:$('[name=add_date_newdate]').val(),
            starttime:$('[name=add_date_starttime]').val(),
            endtime:$('[name=add_date_endtime]').val(),
            note_them_ngay:$('[name=add_date_note]').val(),
        }
        $.ajax({
            type: "POST",
            url: rootUrl+'/detail/add/day',
            data: object_param,
            success: function (response) {
                if(response.status=='success'){
                   // $('#'+object_param.time).fadeOut();
                   location.reload();
                }
                if(response.status=='false'){
                    alert(response.messenger);
                }
            }
        });
    });
    // lệnh xóa ngày
    $('.button__delete-date').click(function () {
        let text = "Thao tác này sẽ xóa vĩnh viễn ngày này, bạn có chắc?";
        if(confirm(text)==true){
            var object_param={
                id_nkgd:$(this).attr("id_nkgd"),
                time: $(this).attr("time"),
                id_subject:$(this).attr("id_subject"),
                id_teacher:$(this).attr("id_teacher")
            }
            $.ajax({
                type: "GET",
                url: rootUrl+'/detail/delete/day',
                data: object_param,
                success: function (response) {
                    if(response.status=='success'){
                        // $('#'+object_param.time).fadeOut();
                        location.reload();
                    }else{
                        console.log(response);
                        alert('Có lỗi, liên hệ webadmin');
                    }
                }
            });
        }
    });
    // Nút reset về trạng thái ban đầu
    $('.button__reset-date').click(function () {
        let text = "Thao tác này sẽ Reset ngày trở về trạng thái ban đầu, bạn có chắc?";
        if(confirm(text)==true){
            var object_param={
                id_nkgd:$(this).attr("id_nkgd"),
                time: $(this).attr("time"),
                id_subject:$(this).attr("id_subject"),
                id_teacher:$(this).attr("id_teacher")
            }
            $.ajax({
                type: "POST",
                url: rootUrl+'/detail/reset',
                data: object_param,
                success: function (response) {
                    if(response.status=='success'){
                        $('#hours_teacher_'+object_param.time).text("0 Giờ")
                        $('#hours_student_'+object_param.time).text("0 Giờ")
                    }else{
                        console.log(response);
                        alert('Có lỗi, liên hệ webadmin');
                    }
                }
            });
        }
    });
    //Sự kiện lệnh xóa môn
    $('.button__delete-subject').click(function () {
        let text = "Thao tác này sẽ xóa vĩnh viễn toàn bộ dữ liệu của môn học này, bạn có chắc?";
        if (confirm(text) == true) {
            var object_param={
                id_nkgd:$(this).attr("id_nkgd"),
                id_subject:$(this).attr("id_subject"),
                id_teacher:$(this).attr("id_teacher")
            }
            $.ajax({
                type: "GET",
                url: rootUrl+'/detail/delete/subject',
                data: object_param,
                success: function (response) {
                    if(response.status=='success'){
                        $('#'+object_param.id_teacher+'_'+object_param.id_subject).fadeOut();
                    }else{
                        console.log(response);
                        alert('Có lỗi, liên hệ webadmin');
                    }
                }
            });
        }
    });
    //Lưu note
    $('.button__save-note').click(function(){
        var object_param={
            id_nkgd:$(this).attr("id_nkgd"),
            time: $(this).attr("time"),
            id_subject:$(this).attr("id_subject"),
            id_teacher:$(this).attr("id_teacher"),
            note:$('#note_'+ $(this).attr("time")).val()
        }
        $.ajax({
            type: "GET",
            url: rootUrl+'/detail/add/note',
            data: object_param,
            success: function (response) {
                if(response.status=='success'){
                    $('#error_note_'+object_param.time).text("Đã lưu!");
                }else{
                    console.log(response);
                    alert('Có lỗi, liên hệ webadmin');
                }
            }
        });
    });
    $('.btn_save-time').click(function(){
        let object_param={
            id_nkgd:$("[name=edit_time_id_nkgd]").val(),
            time: $("[name=edit_time]").val(),
            id_subject:$("[name=edit_time_id_subject]").val(),
            id_teacher:$("[name=edit_time_id_teacher]").val(),
            start_time:$('#edit_time_start').val(),
            end_time:$('#edit_time_end').val()
        }
        $.ajax({
            type: "POST",
            url: rootUrl+'/detail/edit_date',
            data: object_param,
            success: function (response) {
                if(response.status=='success'){
                    location.reload();
                }else{
                    console.log(response);
                    alert('Có lỗi, liên hệ webadmin');
                }
            }
        });
    });
    //Nút điểm danh
    $('.roll_up').change(function () {
        if($('#time_left').text()==" 0 Giờ"){
            alert('Hiện tại bé đã hết giờ!');
        }
        var object_param={
            id_nkgd:$(this).attr("id_nkgd"),
            time: $(this).attr("time"),
            id_subject:$(this).attr("id_subject"),
            id_teacher:$(this).attr("id_teacher"),
            hours:$(this).val(),
            teacher_hours:$(this).val()
        }
        $.ajax({
            type: "GET",
            url: rootUrl+'/detail/add/roll_up',
            data: object_param,
            success: function (response) {
                if(response.status=="success"){
                    $('#hours_teacher_'+object_param.time).text(response.hours+" Hours")
                    $('#hours_student_'+object_param.time).text(response.hours+" Hours")
                    $('#hours_student_'+object_param.time).append("<p class=\"txt-success\">Saved!</p>");
                }else{
                    console.log(response);
                    alert("Lỗi, liên hệ webadmin");
                }
            }
        });
    });
    // Nút điểm danh riêng
    $('.tinh_gio_rieng').click(function () {
        var object_param={
            id_nkgd:$(this).attr("id_nkgd"),
            time: $(this).attr("time"),
            id_subject:$(this).attr("id_subject"),
            id_teacher:$(this).attr("id_teacher"),
            hours:$("#gio_hoc_vien_"+$(this).attr("time")).val(),
            teacher_hours:$("#gio_giao_vien_"+$(this).attr("time")).val()
        }
        $.ajax({
            type: "GET",
            url: rootUrl+'/detail/add/roll_up',
            data: object_param,
            success: function (response) {
                if(response.status=="success"){
                    $('#hours_teacher_'+object_param.time).text(response.teacher_hours+" Hours")
                    $('#hours_student_'+object_param.time).text(response.hours+" Hours")
                    $('#hours_student_'+object_param.time).append("<p class=\"txt-success\">Saved!</p>");
                }else{
                    alert("Lỗi, liên hệ webadmin");
                }
            }
        });
    });
    // Nút đổi ngày
    $('.btn-change-date').click(function () {

        var object_param={
            id_nkgd:$('[name=id_nkgd]').val(),
            old_time: $('[name=old_time]').val(),
            id_subject:$('[name=id_subject]').val(),
            id_teacher:$('[name=id_teacher]').val(),
            id_student:$('[name=id_student]').val(),
            new_date:$('[name=newdate]').val(),
            start_new_time:$('[name=starttime]').val(),
            end_new_time:$('[name=endtime]').val(),
            note_new_time:$('[name=notedoilich]').val()
        }
        $.ajax({
            type: "POST",
            url: rootUrl+'/detail/change_date',
            data: object_param,
            success: function (response) {
                if(response.status=="success"){
                    location.reload();
                }else{
                    alert("Đổi ngày không thành công, liên hệ Web dev");
                }
            }
        });
    });
    /**
     * Phần xử lý renew history
     */
    // Nút lưu renew history
    $('.renew__add').click(function (e) {
        let check_bao_luu= $('[name="reserve_plus"]').val();
        var object_param={
            id_nkgd:$('#renew_id').val(),
            id_student:$('#renew_id_student').val(),
            ten_hoc_sinh:$('#renew_ten_hoc_sinh').val(),
            so_hoa_don:$('#renew_so_hoa_don').val(),
            so_gio:$('#renew_so_gio').val(),
            ngay_bat_dau:$('#renew_ngay_bat_dau').val(),
            ngay_nhan:$('#renew_ngay_nhan').val(),
            so_tien:$('#renew_so_tien').val()
        }
        if(check_bao_luu==1){
            object_param["bao_luu"] = $('[name="reserve_value"]').val();
        }
        // tạo json lịch sử
        if(object_param.id_nkgd==""||object_param.id_student==""||object_param.ten_hoc_sinh==""||object_param.so_hoa_don==""||object_param.so_gio==""||object_param.ngay_bat_dau==""||object_param.ngay_nhan==""||object_param.so_tien==""){
            alert("Bạn vui lòng nhập đầy đủ TẤT CẢ các trường, vui lòng nhập lại!");
        }
        else{
            $.ajax({
                type: "POST",
                url: rootUrl+'/detail/renew_history/add',
                data: object_param,
                success: function (response) {
                    if(response.status=='success'){
                        // let current_hours = $('#time_left').text();
                        // $('#time_left').text(current_hours+response.hours);
                        location.reload();
                    }else{
                        console.log(response);
                        alert('Lỗi, vui lòng liên hệ web-admin');
                    }

                }
            });
        }
    });
    $('.renew__edit').keypress(function (e) {
        if(e.which==13){
            var object_param={
                id_nkgd:$(this).attr("id_nkgd"),
                key:$(this).attr("key"),
                key_name:$(this).attr("key_name"),
                value:$(this).val()
            }
            $.ajax({
                type: "GET",
                url: rootUrl+'/detail/renew_history/edit',
                data: object_param,
                success: function (response) {
                    if(response.status=='success'){
                        //   $('#0_sotientrengio').append('<i class=\"fas fa-check text-success\"></i>');
                        alert("Done!");
                    }else{

                        alert("Lỗi, liên hệ web admin!")
                    }
                }
            });
        }
    });
    $('.renew__edit').tooltip({
        placement: "top",
        trigger: "focus"
    });
    // Nút xóa renew
    $('.renew__delete').click(function (e) {
            var object_param={
                id_nkgd:$(this).attr("id_nkgd"),
                key:$(this).attr("key")
            }
            $.ajax({
                type: "GET",
                url: rootUrl+'/detail/renew_history/delete',
                data: object_param,
                success: function (response) {
                    console.log(response);
                    if(response.status=='success'){
                        $('#renew_'+object_param.key).fadeOut();
                    }else{
                        console.log(response);
                        alert(response.error_messenger)
                    }
                }
            });
    });
   // Nút đồng bộ lại doanh thu
   $('#syns_revenue').click(function(e){
    var object_param={
        id_nkgd:$(this).attr("id_nkgd"),
    }
    $.ajax({
        type: "GET",
        url: rootUrl+'/detail/renew_history/syns_revenue',
        data: object_param,
        success: function (response) {
            if(response.status=='success'){
                //   $('#0_sotientrengio').append('<i class=\"fas fa-check text-success\"></i>');
                location.reload();
            }else{
                alert("Lỗi, liên hệ web admin!")
            }
        }
    });
   });
})
