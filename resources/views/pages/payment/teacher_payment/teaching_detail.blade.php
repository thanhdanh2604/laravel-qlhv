@extends('layouts.vertical.master')
@section('title', 'Teaching detail')
@section('css')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">

@endsection

@section('breadcrumb-title')
<h2>Teaching <span>Details </span></h2>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item ">Trang chủ</li>
<li class="breadcrumb-item ">Payment</li>
<li class="breadcrumb-item active">Teaching detail</li>
@endsection
@section('style')
<style>
.right-side {
  display: flex;
  justify-content: space-between;
  text-align: center;
  align-items: center;
}
</style>
@endsection
@section('content')
<div class="container-fluid">
  <div class="row starter-main">
    <div class="col-sm-12">
      <div class="row" style="min-height: 300px">
        <div style="min-height: 550px" class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
          <div class="card">
            <div class="card-body">
              <span>Giáo viên: <h3><?php echo $detail_teacher->fullname ?></h3><span style="text-align:center">
                  <div style="width:100%;padding:10px 0px;text-align:center;margin:10px 0px"
                    class="nav-teaching-details">
                    <?php if ($next_month!=null||$pre_month!=null) { ?>
                    <h4 style="display:inline;color:green;font-size:25px"><?php echo date('M Y',$month); ?></h4>
                    <a href="{{route('teaching_details',
                                    ['id_teacher' => $detail_teacher->id_teacher,
                                    'month'=>$pre_month]
                                    )}}" style="float:left;font-size:30px;color:chocolate"><i
                        data-feather="chevron-left"></i></a>
                    <a href="{{route('teaching_details',
                                    ['id_teacher' => $detail_teacher->id_teacher,
                                    'month'=>$next_month]
                                    )}}" style="float:right;font-size:30px;color:chocolate"><i
                        data-feather="chevron-right"></i></a>
                    <div style="clear:both"></div>
                    <?php } else { ?>
                    <h4 style="display:inline">Teaching recording: <span
                        style="color:green;font-size:25px"><?php echo date('d-m-Y',strtotime($start_date))."</span> To <span style=\"color:black;font-size:25px\">".date('d-m-Y',strtotime($end_date))."</span>"; ?>
                    </h4>
                    <?php } ?>
                  </div>
                  @php $i=0;@endphp
                  @foreach ($teaching_details as $item)
                  @php $total_hours_student=0;
                  $total_hours_teacher=0;@endphp
                  <p>
                    <button style="width:100%" class="btn btn-pill btn-primary btn-air-primary" type="button" title=""
                      data-toggle="collapse" data-target="#collapse{{$i}}"
                      aria-expanded="false"
                      aria-controls="collapse{{$i}}">{{isset($students[$item->ma_hoc_sinh])?$students[$item->ma_hoc_sinh]:'Group class'}} --
                      {{isset($subjects[$item->ma_mon])?$subjects[$item->ma_mon]:''}} </button>
                  </p>
                  <div class="collapse" id="collapse{{$i}}">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>STT</th>
                          <th>Time</th>
                          <th>Student</th>
                          <th>Teacher</th>
                          <th>Note</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $stt=1 @endphp
                        @php
                        usort($item->lich_hoc_du_kien,function($a,$b){
                          return $a->time <=> $b->time;
                        })
                        @endphp
                        @foreach($item->lich_hoc_du_kien as $chi_tiet_buoi)

                        @if(strtotime($start_date)<=$chi_tiet_buoi->time && strtotime($end_date)>=$chi_tiet_buoi->time)

                          <tr>
                            <td> @php echo $stt; $stt++; @endphp</td>
                            <td>{{date('d-m-Y',$chi_tiet_buoi->time)}}</td>
                            <td>
                              @if (isset($chi_tiet_buoi->hours))
                              <i class="icon-check txt-success f-w-900"></i>
                              @else
                              <i class="txt-danger f-w-900">X</i>
                              @endif
                            </td>
                            <td>
                              <span class="txt-primary f-w-900">
                                @php
                                if(isset($chi_tiet_buoi->teacher_hours)){
                                    echo $chi_tiet_buoi->teacher_hours;
                                    $total_hours_teacher+=$chi_tiet_buoi->teacher_hours;
                                }elseif(isset($chi_tiet_buoi->hours)){
                                    echo $chi_tiet_buoi->hours;
                                    $total_hours_teacher+=$chi_tiet_buoi->hours;
                                }else{
                                echo 0;
                                }
                                @endphp
                              </span>
                            </td>
                            <td>{{
                                  isset($chi_tiet_buoi->note)?$chi_tiet_buoi->note:''
                                  }}</td>
                          </tr>
                          @endif
                          @php $i++;@endphp
                          @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                          <th colspan="2"></th>

                          <th colspan="2">
                            Teaching time: <span id="teaching-time" name="teaching-time"
                              style="color:red">{{$total_hours_teacher}} </span>hours
                          </th>
                          <th></th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                  @endforeach
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 right-side">
          <div>
            <div class="card-body">
              <div style="" class="hpanel shadow-inner responsive-mg-b-30">
                <div class="panel-body">
                    {{-- <label for="">Select teacher:</label>
                    <select class="form-control" name="" id="select_teacher">
                    <?php foreach ($teachers as $teacher) {
                     echo "<option value=\"".$teacher->id_teacher."\">".$teacher->fullname."</option>";
                    }
                      ?>
                    </select> --}}
                    <div class="btn-group">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                Select teacher
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                            <?php foreach ($teachers as $teacher) { ?>
                            <a class="dropdown-item" href="{{route('teaching_details',['id_teacher'=>$teacher->id_teacher])}}">{{$teacher->fullname}}</a>
                            <?php } ?>
                        </div>
                    </div>
                  <table class="table table-striped">
                    <caption>Total:</caption>
                    <thead>
                      <tr>
                        <th>Pay for an hour:</th>
                        <th>Hours</th>
                        <th>Salaries:</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><span><?php echo $detail_teacher->hesoluong.""?> </span> VNĐ </td>
                        <td><span id="hours-teaching"> </span> Hour</td>
                        <td><span id="total-money"> </span> VNĐ</td>
                      </tr>
                     
                       
                      <tr>
                        <td style="text-align:center" colspan="3">
                          
                            <input hidden type="text" name="id_teacher"
                              value="<?php echo $detail_teacher->id_teacher ?>">
                            <input hidden type="text" name="luong_cua_thang" value="<?php echo $month ?>">
                            <input hidden type="text" name="tien_luong" id="chot_tien_luong" value="">
                            <input hidden type="text" name="he_so_luong"
                              value="<?php echo $detail_teacher->hesoluong;?>">
                            <input hidden type="text" name="so_gio" id="chot_gio" value="">
                            <?php if ($status_salary===true) { ?>
                            <button disabled class="btn btn-warning btn-lg">Đã chốt</button>
                            <?php }else{ ?>
                            <button type="submit" id="submit_chot_luong" class="btn btn-success btn-lg">Chốt
                              lương</button>
                            <?php } ?>
                          
                        </td>
                      </tr>
                    </tbody>

                  </table>
                  <script type="text/javascript">
                  var teachtime = document.getElementsByName('teaching-time');
                  var i;
                  var temp = 0;
                  for (i = 0; i < teachtime.length; i++) {
                    temp += parseFloat(teachtime[i].textContent);
                    var total = temp * @php echo $detail_teacher['hesoluong'] @endphp
                  }
                  document.getElementById('chot_gio').value = temp;
                  document.getElementById('chot_tien_luong').value = total;
                  document.getElementById('hours-teaching').innerHTML = temp;
                  document.getElementById('total-money').innerHTML = total.toLocaleString();
                  </script>
                </div>
              </div>
              <div>
                <div class="input-daterange input-group" id="datepicker">
                  <input value="<?php echo $start_date ?>" type="date" class="form-control" id="detail_start_date" />
                  <span class="input-group-addon">to</span>
                  <input value="<?php echo $end_date ?>" type="date" class="form-control" id="detail_end_date" />
                </div>
                <button class="btn btn-info "
                  onclick="var start = document.getElementById('detail_start_date').value;var end = document.getElementById('detail_end_date').value;window.open('?start_date='+start+'&end_date='+end)">Xem
                  chi tiết</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')


<script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
<script>

$('#select_teacher').select2();


$('#submit_chot_luong').click(function (e) { 
  let object_param={
    id_teacher:$('[name="id_teacher"]').val(),
    luong_cua_thang:$('[name="luong_cua_thang"]').val(),
    tien_luong:$('[name="tien_luong"]').val(),
    he_so_luong:$('[name="he_so_luong"]').val(),
    so_gio:$('[name="so_gio"]').val()
  }
  $.ajax({
    type: "GET",
    url: "{{route('salary_check')}}",
    data: object_param,
    success: function (response) {
      $('#submit_chot_luong').removeClass( "btn-success").addClass("btn-warning")
      $('#submit_chot_luong').onclick = null;
    }
  });
});
</script>

@endsection
