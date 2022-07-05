<?php
 use App\Http\Controllers\teaching_recording\details_teaching_recording;
?>

@extends('layouts.vertical.master')
@section('title', 'Dashboard')
@section('css')

@endsection

@section('breadcrumb-title')
	<h2>Dashboard <span>Intertu </span></h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item active">Trang chủ</li>
@endsection
@section('style')
@endsection
@section('content')
<div class="container-fluid">
   <div class="row starter-main">
      <div class="col-sm-12">
        <div class="container-fluid">
            <div style="width:100%;display: flex;justify-content: space-around;align-items:center">
                <a href="?days=<?php echo date('d-m-Y',strtotime(date('d-m-Y',strtotime($days)).'- 1 day')); ?>" style="float:left;font-size:2rem"><i class="icofont icofont-arrow-left"></i></a>
                <form method="GET" action="/">
                    <input type="date" name="days">
                    <input name type="submit" value="Submit">
                </form>
                <a class="btn btn-info btn-sm" href="/">Today</a>
                <?php echo "<div style=\"text-align:center;color:red\"><h1>lịch học ngày ".date('d-m-Y',strtotime($days))."</h1></div>"; ?>
                <a href="?days=<?php echo date('d-m-Y',strtotime(date('d-m-Y',strtotime($days)).'+ 1 day')); ?>" style="float:right;font-size:2rem"><i class="icofont icofont-arrow-right"></i></a>
            </div>
            <table class="table table-border">
                <thead>
                <tr>
                    <th>Date submit</th>
                    <th>Subject</th>
                    <th>Teacher Name</th>
                    <th>Student Name</th>
                    <th>Teaching Hour</th>
                    <th>Trạng thái tính giờ hiện tại</th>
                    <th>Note</th>
                    <th>Tool</th>
                </tr>
                </thead>
                <tbody>

                <?php $stt=1;
                    foreach ($todayClass as $value){?>
                <tr>
                    <td class="<?php
                    if(isset($value->starttime)){
                        if(strtotime($value->starttime)>= strtotime('06:00') && strtotime($value->starttime)<= strtotime('11:59')){
                            echo "morning_panel";
                        }
                        if(strtotime($value->starttime)>= strtotime('12:01') && strtotime($value->starttime)<= strtotime('17:00')){
                            echo "noon_panel";
                        }
                        if(strtotime($value->starttime)>= strtotime('17:01') && strtotime($value->starttime)<= strtotime('24:00')){
                            echo "night_panel";
                        }
                    }
                    ?>">
                    <?php echo (isset($value->starttime)) ?
                    "<div style=\"color:#1e824c;font-weight:bold\">Start:".$value->starttime."<br></div>
                    <div style=\"color:#f22613;font-weight:bold\">End: ".$value->endtime."</div>": "<div>No time</div>";
                    ?>
                    <button type="button" class="btn btn-primary btn-sm modal_edit_time_date_fill_data" data-toggle="modal" data-target="#edit_time_date" time="{{$value->time}}" id_nkgd="{{$value->id}}" id_subject="{{$value->id_subject}}" id_teacher="{{$value->id_prof}}" start_time="{{$value->starttime}}" end_time="{{$value->endtime}}">
                        Edit time
                    </button>
                    </td>
                    <td>
                        <a target="__blank" href="">
                        <?php echo isset($subjects[$value->id_subject])?$subjects[$value->id_subject]:"Deleted" ?></a>
                    </td>
                    <td>
                        <a  target="__blank" class="badge badge-warning" href="{{route('teacher_detail',$value->id_prof)}}">
                        <?php  echo isset($teachers[$value->id_prof])?$teachers[$value->id_prof]:"Deleted";?></a>
                    </td>
                    <td>
                        <a target="__blank" class="badge badge-dark" href="{{route('student_detail',$value->id_student)}}">
                        <?php
                        if(is_array($value->id_student)){
                          var_dump($value->id_student);
                        }else{
                          echo isset($students[$value->id_student])?$students[$value->id_student]:"Deleted";
                        }
                             
                        ?></a>
                         <?php
                            $array_time_study = details_teaching_recording::getStudyInfo($value->id);
                            if($array_time_study['time_left']<=6){
                                echo "<span class=\"badge badge-danger\">".$array_time_study['time_left']." Hours</span>";
                            }else{
                                echo "<span class=\"badge badge-success\">".$array_time_study['time_left']." Hours</span>";
                            }
                            
                         ?>
                            <a class="btn btn-default" href="teaching_recordings/detail/{{$value->id}}">Xem NKGD</a>
                    </td>
                    <td>
                        <select id_nkgd="{{$value->id}}" time="{{$value->time}}" id_subject="{{$value->id_subject}}" id_teacher="{{$value->id_prof}}" class="roll_up form-control" style="display:block">
                            <option selected value="{{isset($value->hours)?$value->hours:0}}">{{isset($value->hours)?$value->hours.' Hours':'Chưa điểm danh!'}} </option>
                            <option value="1">1 hours</option>
                            <option value="1.5">1.5 hours</option>
                            <option value="2">2 hours</option>
                            <option value="2.5">2.5 hours</option>
                            <option value="3">3 hours</option>
                            <option value="3.5">3.5 hours</option>
                            <option value="4">4 hours</option>
                            <option value="4.5">4.5 hours</option>
                        </select>
                        <div data-toggle="collapse" data-target="#panel-tinh-gio-rieng_{{$value->time}}" aria-expanded="false"  style="margin-top:5px" class="btn btn-outline-secondary">Tính giờ riêng</div>
                        <div style="width:100%" id="panel-tinh-gio-rieng_{{$value->time}}" class="tinh-rieng-gio collapse">
                            <input class="form-control" type="text" value="" id="gio_giao_vien_{{$value->time}}" placeholder="Giờ giáo viên (VD: 1.5)">
                            <input class="form-control" type="text" value="" id="gio_hoc_vien_{{$value->time}}" placeholder="Giờ học viên (VD: 2)">
                            <button id_nkgd="{{$value->id}}" time="{{$value->time}}" id_subject="{{$value->id_subject}}" id_teacher="{{$value->id_prof}}" style="display:block" class="tinh_gio_rieng btn btn-success" >Lưu</button>
                        </div>
                    </td>
                    <td>
                        <p> Giờ giáo viên:
                            <span id="hours_teacher_{{$value->time}}" class="text-primary f-w-900">
                            @php
                                if(isset($value->teacher_hours)){
                                    echo $value->teacher_hours;
                                }elseif(isset($value->hours)){
                                    echo $value->hours;
                                }else{ echo 0;}
                            @endphp Giờ </span>
                        </p>
                        <p> Giờ học sinh:<span id="hours_student_{{$value->time}}" class="text-success f-w-900">@php
                            if(isset($value->hours)){
                                echo $value->hours;
                            }else{ echo 0;}
                        @endphp Giờ </span></p>
                    </td>
                    <td>
                        <textarea class="form-control" name="" id="note_{{$value->time}}" cols="10">@php echo isset($value->note)?$value->note:''@endphp</textarea>
                        <button id_nkgd="{{$value->id}}" time="{{$value->time}}" id_subject="{{$value->id_subject}}" id_teacher="{{$value->id_prof}}" class="button__save-note btn btn-pill btn-primary">
                        Save</span>
                        </button>
                        <div class="f-w-600 txt-success" id="error_note_{{$value->time}}"></div>
                    </td>
                    <td>
                        <div class="btn-group">
                            <div student_name="<?php echo (!is_array($value->id_student)?$students[$value->id_student]:"Deleted")  ?>" teacher_name="<?php echo isset($teachers[$value->id_prof])?$teachers[$value->id_prof]:"Deleted"?>" id_nkgd="{{$value->id}}" title="Change Date" time="{{$value->time}}" id_subject="{{$value->id_subject}}" id_teacher="{{$value->id_prof}}" id_student="{{!is_array($value->id_student)?$students[$value->id_student]:''}}" data-toggle="modal" href='#modal-doi-lich' title="Change" class="btn btn-info modal_change_date_fill_data"><i class="icofont icofont-forward"></i></div>
                            <div id_nkgd="{{$value->id}}" title="Reset" time="{{$value->time}}" id_subject="{{$value->id_subject}}" id_teacher="{{$value->id_prof}}" class="btn btn-primary button__reset-date" title="Reset"><i class="icofont icofont-retweet"></i></div>
                            <div id_nkgd="{{$value->id}}" title="Delete" time="{{$value->time}}" id_subject="{{$value->id_subject}}" id_teacher="{{$value->id_prof}}" class="button__delete-date btn btn-danger"><i class="icofont icofont-ui-delete"></i> </div>
                        </div>
                    </td>
                <tr>
                <?php } ?>
                </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
{{-- Modal Change date --}}
@include('block.modal_change_date')
{{-- Modal edit time --}}
@include('block.modal_change_time_date')
@endsection

@section('script')
<script>
var rootUrl = "{{ route('teaching_recordings')}}";
$('.modal_change_date_fill_data').click(function(){
    $('[name=id_nkgd]').val($(this).attr("id_nkgd"))
    $('[name=time]').val($(this).attr("time"))
    $('[name=id_subject]').val($(this).attr("id_subject"))
    $('[name=id_teacher]').val($(this).attr("id_teacher"))
    $('[name=id_student]').val($(this).attr("id_student"))
    $('.teacher_name_field').text($(this).attr("teacher_name"))
    $('.student_name_field').text($(this).attr("student_name"))
})
$('.modal_edit_time_date_fill_data').click(function(){
    $('[name=edit_time_id_nkgd]').val($(this).attr("id_nkgd"))
    $('[name=edit_time]').val($(this).attr("time"))
    $('[name=edit_time_id_subject]').val($(this).attr("id_subject"))
    $('[name=edit_time_id_teacher]').val($(this).attr("id_teacher"))
    $('#edit_time_start').val($(this).attr("start_time"))
    $('#edit_time_end').val($(this).attr("end_time"))

})
</script>
<script src="{{ asset('assets/js/custom/function.js')}}"></script>
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}" ></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}" ></script>
@endsection
