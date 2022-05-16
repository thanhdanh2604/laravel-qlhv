{{-- Button example --}}
{{-- <div student_name="" teacher_name="" id_nkgd="{{$value->id}}" title="Change Date" time="{{$value->time}}" id_subject="{{$value->id_subject}}" id_teacher="{{$value->id_prof}}" id_student="{{$value->id_student}}" data-toggle="modal" href='#modal-doi-lich' title="Change" class="btn btn-info modal_change_date_fill_data"><i class="icofont icofont-forward"></i></div> --}}
<div class="modal fade" id="modal-doi-lich">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Đổi lịch qua ngày khác</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                    <input hidden type="text" placeholder="idprof" name="id_teacher" >
                    <input hidden type="text" placeholder="idstudent" name="id_student" >
                    <input hidden type="text" placeholder="id_nkgd" name="id_nkgd">
                    <input hidden type="text" placeholder="mamonhoc" name="id_subject">
                    <input hidden type="text" name="old_time" value="<?php echo strtotime($days) ?>">
                    <label>New Date</label>
                    <div class="input-group date">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        <input required name="newdate" class="form-control"  type="date">

                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                        <div style="margin-top:10px" class="form-group input-group">
                            <label>Start time</label>
                            <input class="form-control" name="starttime" type="time" name="start" value="">
                        </div>
                        <div style="margin-top:10px" class="form-group input-group">
                            <label>End time</label>
                            <input class="form-control" name="endtime" type="time" name="end" value="">
                        </div>
                        </div>
                        <div style="margin-top:20px" class="col-lg-6">
                            <label>Teacher Name:</label>
                                <p class="teacher_name_field txt-warning f-w-700">
                                </p>
                            <label>Tên học sinh:</label>
                                <p class="student_name_field txt-info f-w-700">
                                </p>
                        </div>
                    </div>
                    <div style="width:100%" style="margin-top:10px" class="input-group">
                        <label>Note:</label>
                        <textarea data-toggle ="tooltip" title="Muốn lưu note phải bấm nút màu xanh lá cây" style="height:100px" name="notedoilich" class="form-control" name="note"></textarea>
                    </div>
                    <p id="error-modal"></p>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-change-date">Save</button>
                </div>
                </form>
            </div>

        </div>
    </div>
</div>
