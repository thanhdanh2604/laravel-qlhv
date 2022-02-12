@extends('layouts.vertical.master')
@section('title', 'Teachers')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/teaching_recording_style.css') }}">
@endsection

@section('breadcrumb-title')
	{{-- <h2>Dashboard <span>Intertu </span></h2> --}}
@endsection

@section('breadcrumb-items')
	{{-- <li class="breadcrumb-item ">Trang chủ</li>
    <li class="breadcrumb-item active">Teaching Recording Detail</li> --}}
@endsection
@section('style')
@endsection
@section('content')


<div class="container-fluid">
   <div class="row starter-main">
      <div class="col-sm-12">

        {{-- Phần header hiển thị tên NKGD, các nút Thêm giáo viên, Thêm Buổi, Thêm nhiều buổi --}}
        <div class="card m-b-10">
            <div class="p-20">
                {{-- <span class="f-w-700 f-30">{{$teaching_recording->name}}</span> --}}
                <span class="f-w-700 text-success f-30">Student: {{$students->full_name}}</span> -
                <span class="f-w-700 text-primary f-30">{{isset($teaching_recording->ma_lop)?$teaching_recording->ma_lop:''}}</span>
                <div class="btn-group f-right" role="group" aria-label="Basic example">
                    <button data-toggle="modal" data-target="#modal_them-giao-vien" class="btn btn-warning" type="button">Thêm giáo viên + môn học</button>
                    <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalthem1buoi">Thêm 1 buổi</button>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#them_nhieu_buoi" type="button">Thêm nhiều buổi</button>
                </div>
            </div>
        </div>
        {{-- Phần thông báo khi tạo mới NKGD hướng dẫn các bước tiếp theo --}}
        @if($teaching_recording->teaching_history==null)
        <div class="card">
            <div class="card-body">
                <h1>Bấm nút  <span data-toggle="modal" data-target="#modal_them-giao-vien" class="btn btn-warning" type="button">Thêm giáo viên + môn học</span> để thêm môn và giáo viên</h1>
            </div>
        </div>
        @endif
        {{-- Header thông báo giờ còn lại, thời gian học, nút renew khóa học --}}
        @if($teaching_recording->teaching_history!=null)
          <div class="card">
                <div class="header_teaching_recording p-15">
                    <div style="display:none">
                        <label>Tổng thời gian:</label>
                        <input type="text" id="total_hours" value="{{$teaching_recording->total_hours}}" placeholder="">
                        <div onclick="ajax_save_total_hour()" class="btn btn-primary">Lưu giờ</div>
                    </div>
                    <div>
                        <button data-toggle="modal" data-target="#renew" class="btn btn-info" type="button" data-original-title="" title="">Renew</button>
                    </div>
                    <div class="gio_da_hoc">
                        <h3>Giờ đã học</h3>
                        <span style="color:blue;font-size:30px;font-weight: 900">{{$study_info['study_hours']}} Giờ</span><span style='font-size:20px'></span>
                    </div>
                    <div class="gio_con_lai">
                        <h3>Thời gian còn lại</h3>
                        <span style="@php if($study_info['time_left']<=6){ echo "color:red"; }else{ echo "color:green";} @endphp;font-size:30px;font-weight: 900"> {{$study_info['time_left']}} Giờ</span>
                    </div>
                    <div class="so_tien_bao_luu">
                        <h3 >Số tiền bảo lưu</h3>
                        <span style="color:black;font-size:30px;font-weight: 900">{{number_format($students->reserve)}} VNĐ</span>
                    </div>
                </div>
          </div>
        @endif
        {{-- Phần hiển thị nhật ký giảng dạy dạng tab --}}
        <div class="card border-primary">
            <div class="card-body">
                @if($teaching_recording->teaching_history!=null)
                    @foreach ($obj_teaching_history as $obj_mon_hoc)
                        <caption><span class="f-w-900">{{$teachers[$obj_mon_hoc->ma_giao_vien]}}</span> ---
                        <span class="f-w-900 text-danger">{{$subjects[$obj_mon_hoc->ma_mon]}}</span></caption>
                        <table id="{{$obj_mon_hoc->ma_giao_vien}}_{{$obj_mon_hoc->ma_mon}}" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Teacher & Subject</th>
                                    <th>Teaching time</th>
                                    <th>Note</th>
                                    <th>Trạng thái thực tế</th>
                                    <th>Tool</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($obj_mon_hoc->lich_hoc_du_kien==null)
                                <tr>
                                    <td style="text-align:center" class="middle" colspan="7">
                                        <div class="btn-group f-center" role="group" aria-label="Basic example">
                                            <button class="btn btn-success" type="button">Thêm 1 buổi</button>
                                            <button class="btn btn-primary" type="button">Thêm nhiều buổi</button>
                                        </div>
                                    </td>
                                </tr>

                                @endif
                                @php
                                    $stt=1;
                                @endphp
                                @foreach ($obj_mon_hoc->lich_hoc_du_kien as $buoi_hoc)
                                        <tr>
                                            <td>@php echo $stt; $stt++; @endphp</td>
                                            <td>
                                                <div class="f-w-700 f-c-red">{{ $buoi_hoc->date}}</div>
                                                @php
                                                if(isset($buoi_hoc->starttime)){
                                                    echo "<div style=\"color:#1e824c;font-weight:bold\">Start: ".$buoi_hoc->starttime."</div>";
                                                    echo "<span style=\"color:#f22613;font-weight:bold\">End: ".$buoi_hoc->endtime."</span>";
                                                }
                                                @endphp
                                            </td>
                                            <td>
                                                <p>TEACHER: <a class="f-w-900 " href="/teachers/detail/{{$obj_mon_hoc->ma_giao_vien}}">{{$teachers[$obj_mon_hoc->ma_giao_vien]}}</a>
                                                </p>
                                                <p>SUBJECT: <a class="f-w-900" href="#">{{$subjects[$obj_mon_hoc->ma_mon]}}</a></p>
                                            </td>
                                            <td>
                                                <select value="" class="form-control" style="display:block" name="day_hours" onchange="ajaxsavehour()">
                                                    <option selected value="{{isset($buoi_hoc->hours)?$buoi_hoc->hours:0}}">{{isset($buoi_hoc->hours)?$buoi_hoc->hours:0}} Hours</option>
                                                    <option value="1">1 hours</option>
                                                    <option value="1.5">1.5 hours</option>
                                                    <option value="2">2 hours</option>
                                                    <option value="2.5">2.5 hours</option>
                                                    <option value="3">3 hours</option>
                                                    <option value="3.5">3.5 hours</option>
                                                    <option value="4">4 hours</option>
                                                    <option value="4.5">4.5 hours</option>
                                                </select>
                                                <div data-toggle="collapse" data-target="#panel-tinh-gio-rieng_{{$obj_mon_hoc->ma_giao_vien."_".$obj_mon_hoc->ma_mon}}" aria-expanded="false"  style="margin-top:5px" class="btn btn-outline-secondary">Tính giờ riêng</div>
                                                <div style="width:100%" id="panel-tinh-gio-rieng_{{$obj_mon_hoc->ma_giao_vien."_".$obj_mon_hoc->ma_mon}}" class="tinh-rieng-gio collapse">
                                                    <input class="form-control" type="text" value="" id="gio_giao_vien_" placeholder="Giờ giáo viên (VD: 1.5)">
                                                    <input class="form-control" type="text" value="" id="gio_hoc_vien_" placeholder="Giờ học viên (VD: 2)">
                                                    <button style="display:block" class="btn btn-success" onclick="luu_gio_rieng()">Lưu</button>
                                                </div>
                                            </td>
                                            <td>
                                                {{-- {{isset($buoi_hoc->note)?$buoi_hoc->note:''}} --}}
                                                <textarea class="width:800px" class="form-control" name="" id="" cols="10">@php echo isset($buoi_hoc->note)?$buoi_hoc->note:''@endphp
                                            </textarea></td>
                                            <td>
                                                <p> Giờ giáo viên:
                                                    <span class="text-primary f-w-900">
                                                    @php
                                                        if($buoi_hoc->dd_prof==1){
                                                        if(isset($buoi_hoc->teacher_hours)){
                                                            echo $buoi_hoc->teacher_hours;
                                                        }elseif(isset($buoi_hoc->hours)){
                                                            echo $buoi_hoc->hours;
                                                        }}else{ echo 0;}
                                                    @endphp Giờ </span>
                                                </p>
                                                <p> Giờ học sinh:<span class="text-success f-w-900">@php
                                                    if($buoi_hoc->dd_student==1){
                                                            echo $buoi_hoc->hours;
                                                    }else{ echo 0;}
                                                @endphp Giờ </span></p>
                                            </td>
                                            <td>
                                                <div class="btn btn-danger">Xóa {{$buoi_hoc->time}}</div>
                                            </td>
                                        </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endforeach
                @endif
            </div>
        </div>
      </div>
   </div>
</div>
{{-- Nút NAV fixed  --}}
@if($teaching_recording->teaching_history!=null)
<div style="position:fixed; top:35px;left:50%;z-index:9999999;width:300px" class="dropdown">
    <button  class="btn btn-lg btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Môn & Giáo viên</button>
    <ul class="dropdown-menu">
        @foreach (json_decode($teaching_recording->teaching_history) as $obj_mon_hoc)
            @if(!isset($value->finish))
            <li>
                <a class="btn" href="#{{$obj_mon_hoc->ma_giao_vien}}_{{$obj_mon_hoc->ma_mon}}" type="button" class="">{{$teachers[$obj_mon_hoc->ma_giao_vien]}}-{{$subjects[$obj_mon_hoc->ma_mon]}}
                </a>
            </li>
            @endif
        @endforeach
    </ul>
</div>
@endif
<!-- Modal Thêm giáo viên + Môn học -->
<div class="modal fade" id="modal_them-giao-vien" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <form action="{{route('add_new_subject')}}" method="get">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Teacher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                        <input type="text" hidden value="{{$teaching_recording->id}}" name="id_nkgd">
                        <div id="chosse_teacher">
                            <div class="form-group">
                                <label style="color:red;font-size:20px">Step 1: Choose Teacher</label>
                                <select name="id_teacher" onchange="get_current_subject_teacher(this.value);" class="form-control">
                                    <option selected="">Select Teacher</option>
                                    @foreach ($teachers as $id_teacher => $name)
                                    <option value="{{$id_teacher}}">{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="choose_subject">
                            <label style="color:red;font-size:20px">Step 2: Choose Subject </label>
                            <select name="id_subject" id="get_id_packet" class="form-control">
                                <option selected> Select Subject</option>
                            </select>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" class="btn btn-primary">Thêm</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal renew gói -->
<div id="renew" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Renew packet</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
                <div class="modal-body">
                    <input hidden type="text" id="renew_id_student" value='{{$teaching_recording->id_student}}' placeholder="">
                    <input hidden type="text" id="renew_id" value='{{$teaching_recording->id}}' placeholder="">
                    <div class="form-group">
                        <label>Tên học sinh</label>
                        <input class="form-control" type="text" id="renew_ten_hoc_sinh" value="" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Số hóa đơn</label>
                        <input class="form-control" type="text" id="renew_so_hoa_don" value="" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Gói giờ (số giờ)</label>
                        <input class="form-control" type="number" id="renew_so_gio" value="" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Ngày bắt đầu</label>
                        <input class="form-control" type="date" id="renew_ngay_bat_dau" value="" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Ngày nhận</label>
                        <input class="form-control" type="date" id="renew_ngay_nhan" value="" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Số tiền</label>

                        <input class="form-control" pattern="\d+" type="number" id="renew_so_tien" value="" placeholder="">
                        <?php if($students->reserve>0){ ?>
                        <div class="alert alert-warning mg-t-30">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Chú ý!</strong> Bé còn bảo lưu {{number_format($students->reserve)}} VNĐ, bạn có muốn cộng thêm số tiền đã bảo lưu vào gói giờ này?
                            <div class="radio">
                                <label>
                                    <input type="radio" name="reserve_plus" id="" value="1" >
                                    Có
                                </label>
                                <label>
                                    <input type="radio" name="reserve_plus" id="" value="0" checked="checked">
                                    không
                                </label>
                            </div>
                            <input type="hidden" name="reserve_value" value="{{$students->reserve}}">
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="ajax_history_renew()" data-dismiss="modal" class="btn btn-info" >Renew</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

        </div>
    </div>
</div>
{{-- Modal Thêm một buổi --}}
<div class="modal fade" id="modalthem1buoi">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm một buổi </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('add_day_teaching_history')}}" method="get" accept-charset="utf-8">
                    <div class="form-group-inner">
                        <label>Chọn môn:</label>
                        <div class="form-group" >
                            <select onchange="chon_subject_them_mot_buoi()" id="select_packet_them_buoi" class="form-control">
                                <option selected disabled="" >Pick one</option>}
                                @foreach (json_decode($teaching_recording->teaching_history) as $obj_mon_hoc)
                                    <option value="{{$obj_mon_hoc->ma_giao_vien."_".$obj_mon_hoc->ma_mon}}">{{$teachers[$obj_mon_hoc->ma_giao_vien]}} - {{$subjects[$obj_mon_hoc->ma_mon]}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input hidden type="text" placeholder="Mã giáo viên" id="idprof" name="idprof" value="" >
                        <input hidden type="text" placeholder="Mã môn học" id="mamonhoc" name="mamonhoc" value="">
                        <input type="text" placeholder="Mã học sinh" hidden name="idstudent" value='{{$teaching_recording->id_student}}' >
                        <input type="text" hidden name="name" value="{{$teaching_recording->name}}" >
                        <input type="text" hidden name="id" value="{{$teaching_recording->id}}" >
                        <input type="text" hidden name="malop" value="{{$teaching_recording->ma_lop}}" >
                        <div class="form-group">
                            <label>New Date</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input name="newdate" type="date" class="form-control">
                            </div>
                        </div>
                        <div style="margin-top:10px" class="form-group">
                            <label>Start At:</label>
                            <input name="starttime" type="time" name="start" value="">
                        </div>
                        <div style="margin-top:10px" class="form-group">
                            <label>End at:</label>
                            <input name="endtime" type="time" name="end" value="">
                        </div>
                        <div style="width:100%" style="margin-top:10px" class="form-group">
                            <label>Note</label>
                            <textarea style="height:200px" name="notedoilich" class="form-control" name="note"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input class="btn btn-success" type="submit" name="" value="Submit">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Modal thêm nhiều buổi -->
<div class="modal fade" id="them_nhieu_buoi" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Timetable</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form id="" action="{{route('add_day_range_teaching_history')}}" method="get">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <input name="id" id="id" type="text" value="{{$teaching_recording->id}}" hidden="">
                            <input name="id_student" id="id_student" type="text" value="{{$teaching_recording->id_student}}" hidden="">
                            <input id="json_lich_hoc" name="lich_hoc" hidden type="text">
                            <label class="f-w-600" style="margin-top:20px;color:red;font-size:20px"> Step 1: Pick Subject:</label>
                            <div class="form-group">
                                <select id="selectpacket" name="select_packet" class="form-control">
                                    <option selected="">Pick one</option>
                                    @foreach (json_decode($teaching_recording->teaching_history) as $obj_mon_hoc)
                                        @if(!isset($value->finish))
                                        <option value="{{$obj_mon_hoc->ma_giao_vien}}_{{$obj_mon_hoc->ma_mon}}">
                                            Giáo viên: {{$teachers[$obj_mon_hoc->ma_giao_vien]}} - Môn: {{$subjects[$obj_mon_hoc->ma_mon]}}
                                        </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <label class="f-w-600" style="margin-top:20px;color:red;font-size:20px"> Step 2: Pick Start &amp; End date</label>
                            <div class="input-daterange input-group" id="datepicker">
                                <input name="start_date" type="date" class="form-control" id="start_date">
                                <input name="end_date" type="date" class="form-control" id="end_date">
                            </div>
                            <div style="margin-top:20px" class="form-group" id="chontimetable">
                                <label class="f-w-600" style="color:red;font-size:20px">Step 3: Pick new timetable</label>
                                <div class="thungay f-w-600 f-20">
                                    <label class="checkbox-inline m-r-10">
                                        <input data-toggle="collapse" href="#hthu2" aria-expanded="false" aria-controls="hthu2" class="check_days" type="checkbox" id="thu2">Thứ 2</label>
                                    <label class="checkbox-inline m-r-10">
                                        <input data-toggle="collapse" href="#hthu3" aria-expanded="false" aria-controls="hthu3" class="check_days" type="checkbox" id="thu3">Thứ 3</label>
                                    <label class="checkbox-inline m-r-10">
                                        <input data-toggle="collapse" href="#hthu4" aria-expanded="false" aria-controls="hthu4" class="check_days" type="checkbox" id="thu4">Thứ 4</label>
                                    <label class="checkbox-inline m-r-10">
                                        <input data-toggle="collapse" href="#hthu5" aria-expanded="false" aria-controls="hthu5" class="check_days" type="checkbox" id="thu5">Thứ 5</label>
                                    <label class="checkbox-inline m-r-10">
                                        <input data-toggle="collapse" href="#hthu6" aria-expanded="false" aria-controls="hthu6" class="check_days" type="checkbox" id="thu6">Thứ 6</label>
                                    <label class="checkbox-inline m-r-10">
                                        <input data-toggle="collapse" href="#hthu7" aria-expanded="false" aria-controls="hthu7" class="check_days" type="checkbox" id="thu7">Thứ 7</label>
                                    <label class="checkbox-inline m-r-10">
                                        <input data-toggle="collapse" href="#hchunhat" aria-expanded="false" aria-controls="hchunhat" class="check_days" type="checkbox" id="chunhat">Chủ nhật</label>
                                </div>
                                <div class="input_thoi_gian">
                                    <div class="collapse" id="hthu2">
                                        <p>Lịch thứ 2</p>
                                        <label>Start at <input id="sthu2" type="time"></label>
                                        <label>End at <input id="ethu2" type="time"></label>
                                    </div>
                                    <div class="collapse" id="hthu3">
                                        <p>Lịch thứ 3</p>
                                        <label>Start at <input id="sthu3" type="time"></label>
                                        <label>End at <input id="ethu3" type="time"></label>
                                    </div>
                                    <div class="collapse" id="hthu4">
                                        <p>Lịch thứ 4</p>
                                        <label>Start at <input id="sthu4" type="time"></label>
                                        <label>End at <input id="ethu4" type="time"></label>
                                    </div>
                                    <div class="collapse" id="hthu5">
                                        <p>Lịch thứ 5</p>
                                        <label>Start at <input id="sthu5" type="time"></label>
                                        <label>End at <input id="ethu5" type="time"></label>
                                    </div>
                                    <div class="collapse" id="hthu6">
                                        <p>Lịch thứ 6</p>
                                        <label>Start at <input id="sthu6" type="time"></label>
                                        <label>End at <input id="ethu6" type="time"></label>
                                    </div>
                                    <div class="collapse" id="hthu7">
                                        <p>Lịch thứ 7</p>
                                        <label>Start at <input id="sthu7" type="time"></label>
                                        <label>End at <input id="ethu7" type="time"></label>
                                    </div>
                                    <div class="collapse" id="hchunhat">
                                        <p>Lịch Chủ nhật</p>
                                        <label>Start at <input id="schunhat" type="time"></label>
                                        <label>End at <input id="echunhat" type="time"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>
@if ($errors->any())
<script>
@foreach ($errors->all() as $error)
alert('{{ $error }}')
@endforeach
</script>
@endif

@endsection

@section('script')
<script>
    //Bắt sự kiện click vào submit để điền json lịch học vô input json_lich_hoc
    document.querySelector('#them_nhieu_buoi [type=submit]').addEventListener("click",tao_json_lich_hoc)
    function tao_json_lich_hoc(){
        var gio={};
        document.querySelectorAll('.check_days').forEach(function(element){
            if (element.checked == true) {
                gio[element.id] = {
                    "start": document.getElementById('s'+element.id).value,
                    "end": document.getElementById('e'+element.id).value
                }
            }
        })
        document.getElementById('json_lich_hoc').value = JSON.stringify(gio);
    }

    //end
    document.getElementById('select_packet_them_buoi').addEventListener("change",function(){
        var vitridaugach = this.value.search('_');
        var id_teacher = this.value.substring(0,vitridaugach);
        var id_subject = this.value.substr(vitridaugach+1);
        document.getElementById('idprof').value=id_teacher;
        document.getElementById('mamonhoc').value=id_subject;
    })
    function get_current_subject_teacher(id_teacher){
        var xhttp = new XMLHttpRequest();
        document.getElementById("get_id_packet").innerHTML = "<option> Chọn môn học</option>"
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var obj = JSON.parse(this.responseText);
                obj.forEach(element => {
                    //tạo mã html gắng vào select
                    var opt = document.createElement('option');
                    opt.appendChild( document.createTextNode(element.name) );
                    opt.value = element.id;
                    document.getElementById("get_id_packet").appendChild(opt);
                });
            }
        };
        xhttp.open("GET",'{{route('teachers')}}/json_get_currect_subject_teacher/'+id_teacher, true);
        xhttp.send();
    }
</script>
<script src="{{ asset('assets/js/custom/function.js')}}"></script>
<script src="{{ asset('assets/js/select2/select2.full.min.js') }}" ></script>
<script src="{{ asset('assets/js/select2/select2-custom.js') }}" ></script>
@endsection
