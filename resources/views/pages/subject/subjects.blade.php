<?php
 use App\Http\Controllers\teaching_recording\details_teaching_recording;
?>
@extends('layouts.vertical.master')
@section('title', 'Subject')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">

@endsection

@section('breadcrumb-title')
	<h2>Subjects <span> </span></h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item ">Trang chủ</li>
    <li class="breadcrumb-item active">Subjects</li>
@endsection
@section('style')
@endsection
@section('content')
<div class="container-fluid">
   <div class="row starter-main">
      <div class="col-sm-12">
        <div class="card-body">
            <div class="row ">
                <div style="margin-left: 10px" class="col-lg-8 white-box">
                    <table class="table cell-border" id="basic-1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Subject name</th>
                                <!-- <th>CTQT - CCQT</th>
                                <th>Năm</th>
                                <th>Phân Môn</th>
                                <th>Cấp độ</th> -->
                                <th>Tool</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $stt = 1; foreach ($subjects as $key => $value) { ?>

                            <tr>
                                <td><?php echo $stt; ?></td>
                                <td>
                                    <?php echo $value->name; ?>
                                    <span class="input-group">
                                      <span data-toggle="collapse" href="#edit_name_subject_<?php echo $value->id; ?>" role="button" aria-expanded="false" aria-controls="collapseExample" ><i data-feather="edit-3"></i></span>
                                      <div class="collapse" id="edit_name_subject_<?php echo $value->id; ?>">
                                          <input title="press enter to save!" type="text" id_subject="<?php echo $value->id; ?>" class="form-control update_subject" data_field="name" value="<?php echo $value->name; ?>">
                                      </div>
                                    </span>
                                </td>
                                <td> <div id_subject="<?php echo $value->id; ?>" class="btn btn-danger delete_subject"> Delete</div></td>
                            </tr>
                            <?php $stt++;} ?>
                        </tbody>
                    </table>

                </div>
                <div style=" margin-left:10px;position: sticky;" class="col-lg-3 white-box">
                    <div id="add-subject">
                        <h3> Add more Subject</h3>
                        <div accept-charset="utf-8">
                            <div class="form-group">
                                <label for="subject_name">Subject Name:</label>
                                <input id="subject_name" class="form-control" type="text" name="subject-name" value="" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Note: </label>
                                <input class="form-control" type="text" name="des-subject" value="" placeholder="">
                            </div>
                            <button class="btn btn-info create_subject" type="submit">Add new Subject</button>
                        </div>
                    </div>
                    <hr>

                </div>
            </div>
        </div>
      </div>
   </div>
</div>
@endsection

@section('script')
<script>
  $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
  $('.update_subject').keypress(function (e){
      if(e.which===13){
        var object_param={
            id_subject:$(this).attr("id_subject"),
            field:$(this).attr("data_field"),
            value:$(this).val()
          }
          $.ajax({
              type: "GET",
              url:'{{route('update_subject_info')}}',
              data: object_param,
              success: function (response) {
                  if(response.status=='success'){
                    location.reload();
                  }else if(response.status=='false'){
                      alert(response.messenger);
                  }
              }
        });
      }
    });
    $('.create_subject').click(function (e){
        let object_param={
            subject_name:$("#subject_name").val(),
            note:$("[name='des-subject']").val()
          }
          $.ajax({
              type: "POST",
              url:'{{route('create_subject')}}',
              data: object_param,
              success: function (response) {
                if(response.status=='success'){
                  location.reload()
                }else if(response.status=='false'){
                    alert(response.messenger);
                }
              }
        });
      
    });
    $('.delete_subject').click((e)=>{
          e.preventDefault();
          let object_param={
            id_subject:e.target.getAttribute("id_subject")
          }
          $.ajax({
              
              url:'{{route('delete_subjects')}}',
              type: "POST",
              data: object_param,
              success: function (response) {
                if(response.status=='success'){
                  location.reload()
                }else if(response.status=='false'){
                    alert(response.messenger);
                }
              }
        });
    })
</script>
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}" ></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}" ></script>
<script src="{{ asset('assets/js/select2/select2.full.min.js') }}" ></script>
<script src="{{ asset('assets/js/select2/select2-custom.js') }}" ></script>

@endsection

