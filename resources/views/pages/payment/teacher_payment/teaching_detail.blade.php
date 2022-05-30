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
    .right-side{
        display: flex;
        justify-content: space-between;
        text-align: center;
        align-items: center;
    }
</style>
@endsection
@section('content')
<?php $ktrachotluong=1 ?>
<div class="container-fluid">
   <div class="row starter-main">
        <div class="col-sm-12">
            <div class="row" style="min-height: 300px">
                <div style="min-height: 550px" class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <span>Giáo viên: <h3><?php echo $detail_teacher->fullname ?></h3><span style="text-align:center">
                            <div style="width:100%;padding:10px 0px;text-align:center;margin:10px 0px" class="nav-teaching-details">
                                <?php if (isset($month)) { ?>
                                    <h4 style="display:inline;color:green;font-size:25px"><?php echo date('M Y',$month); ?></h4>
                                    <a href="{{route('teaching_details',
                                    ['id_teacher' => $detail_teacher->id_teacher,
                                    'month'=>$pre_month]
                                    )}}" style="float:left;font-size:30px;color:chocolate" ><i data-feather="chevron-left"></i></a>
                                    <a href="{{route('teaching_details',
                                    ['id_teacher' => $detail_teacher->id_teacher,
                                    'month'=>$next_month]
                                    )}}" style="float:right;font-size:30px;color:chocolate"><i data-feather="chevron-right"></i></a>
                                    <div style="clear:both"></div>
                                <?php } else { ?>
                                        <h4 style="display:inline">Teaching recording: <span style="color:green;font-size:25px"><?php echo date('d-m-Y',strtotime($start_date))."</span> To <span style=\"color:black;font-size:25px\">".date('d-m-Y',strtotime($end_date))."</span>"; ?> </h4>
                                <?php } ?>
                            </div>
                            @foreach ($teaching_details as $item)
                                <p>
                                    <button style="width:100%" class="btn btn-pill btn-primary btn-air-primary" type="button" title="" data-toggle="collapse" data-target="#{{$item->ma_hoc_sinh."_".$item->ma_mon}}" aria-expanded="false"
                                    aria-controls="{{$item->ma_hoc_sinh."_".$item->ma_mon}}">{{$students[$item->ma_hoc_sinh]}} -- {{$subjects[$item->ma_mon]}}  </button>
                                </p>
                                <div class="collapse" id="{{$item->ma_hoc_sinh."_".$item->ma_mon}}">
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
                                            @foreach($item->lich_hoc_du_kien as $chi_tiet_buoi)
                                            @if(strtotime($start_date)<=$key2 && strtotime($end_date)>=$key2)

                                            <tr>
                                                <td></td>
                                                <td>{{date('d-m-Y',$chi_tiet_buoi->time)}}</td>
                                                <td>
                                                    @if (isset($chi_tiet_buoi->hours))
                                                    <i class="icon-check txt-success f-w-900"></i>
                                                    @else
                                                    <i class="icon-close txt-danger f-w-900"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="txt-primary f-w-900">
                                                    {{
                                                    isset($chi_tiet_buoi->teacher_hours)?$chi_tiet_buoi->teacher_hours:(isset($chi_tiet_buoi->hours)?$chi_tiet_buoi->hours:0)
                                                    }}
                                                    </span>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 right-side">
                    <div class="card">
                        <div class="card-body">
                            <div style="width:350px" class="hpanel shadow-inner responsive-mg-b-30">
                                <div class="panel-body">
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
                                        <td><span ><?php echo $detail_teacher->hesoluong.""?> </span> VNĐ </td>
                                        <td><span  id="hours-teaching">  </span> Hour</td>
                                        <td><span  id="total-money"> </span> VNĐ</td>
                                      </tr>
                                      <?php
                                      if (!(isset($_GET['start_date'])&& isset($_GET['end_date'] ))) { ?>
                                      <tr>
                                          <td style="text-align:center" colspan="3">
                                            <form action="teaching-details.php" method="get">
                                              <input hidden type="text" name="id_teacher" value="<?php echo $detail_teacher->id_teacher ?>" >
                                              <input hidden type="text" name="luong_cua_thang" value="<?php echo $month ?>">
                                              <input hidden type="text" name="tien_luong" id="chot_tien_luong" value="">
                                              <input hidden type="text" name="he_so_luong" value="<?php echo $detail_teacher->hesoluong;?>">
                                              <input hidden type="text" name="so_gio" id="chot_gio" value="">
                                              <?php if ($ktrachotluong==1) { ?>
                                                <div disabled class="btn btn-success btn-lg">Đã chốt</div>
                                             <?php }else{ ?>
                                              <button type="submit" name="submit_chot_luong" class="btn btn-success btn-lg">Chốt lương</button>
                                             <?php } ?>
                                            </form>
                                          </td>
                                      </tr>
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                  <script type="text/javascript">
                                          var teachtime = document.getElementsByName('teaching-time');
                                          var i;var temp = 0;
                                          for (i = 0; i < teachtime.length; i++) {
                                            temp+= parseFloat(teachtime[i].textContent);
                                            var total = temp*1;
                                          }
                                          document.getElementById('chot_gio').value = temp;
                                          document.getElementById('chot_tien_luong').value = total;
                                          document.getElementById('hours-teaching').innerHTML = temp;
                                          document.getElementById('total-money').innerHTML= total.toLocaleString();


                                        </script>
                                </div>
                            </div>
                             <div style="" class="white-box">
                                <div class="input-daterange input-group"
                                    id="datepicker">
                                    <input value="<?php echo $start_date ?>" type="date" class="form-control"
                                        id="detail_start_date" />
                                    <span class="input-group-addon">to</span>
                                    <input value="<?php echo $end_date ?>"  type="date" class="form-control"
                                        id="detail_end_date" />
                                </div>
                                <button class="btn btn-info " onclick="var start = document.getElementById('detail_start_date').value;var end = document.getElementById('detail_end_date').value;window.open('teaching-details.php?id_teacher=<?php echo $detail_teacher->id_teacher; ?>'+'&start_date='+start+'&end_date='+end)">Xem chi tiết</button>
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

{{-- <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}" ></script> --}}
<script src="{{ asset('assets/js/select2/select2.full.min.js') }}" ></script>
<script src="{{ asset('assets/js/select2/select2-custom.js') }}" ></script>

@endsection