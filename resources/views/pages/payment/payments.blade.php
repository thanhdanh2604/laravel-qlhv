@extends('layouts.vertical.master')
@section('title', 'Payment')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">

@endsection

@section('breadcrumb-title')
	<h2>Dashboard <span>Intertu </span></h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item active">Payment</li>
@endsection
@section('style')
@endsection
@section('content')
<div class="container-fluid">

       <div class="row">
          <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                  <h5>Basic Tabs</h5>
                </div>
                <div class="card-body">
                  <ul class="nav nav-pills nav-info" id="myTab" role="tablist">
                    <li class="nav-item ">
                        <a class="nav-link active" data-toggle="tab" role="tab" aria-controls="profile" aria-selected="false" data-toggle="tab" href="#teacher_payment"><span class="edu-icon edu-analytics tab-custon-ic"></span>Teacher Payment</a>
                    </li>
                    <li>
                        <a class="nav-link" data-toggle="tab" role="tab" aria-controls="profile" aria-selected="false" data-toggle="tab" href="#student_payment"><span class="edu-icon edu-analytics-arrow tab-custon-ic"></span>Student Payment</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="teacher_payment" >
                        <div class="table-responsive">
                            <table class="table" id="table_teacher_payment">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên Giáo viên</th>
                                        <th>Ngày chốt lương</th>
                                        <th>Lương của tháng</th>
                                        <th>Số tiền</th>
                                        <th>Hệ số lương</th>
                                        <th>Số giờ chốt</th>
                                        <th>Đã chuyển khoản</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $stt_payment=1; foreach ($payments as $detail_payment) {
                                        $ten_gv = isset($teachers[$detail_payment['id_teacher']])?$teachers[$detail_payment['id_teacher']]:'Deleted Teacher';
                                        ?>
                                    <tr>
                                        <td><?php echo $stt_payment; ?></td>
                                        <td><?php echo $ten_gv ?></td>
                                        <td><?php echo date('F j, Y, g:i a',$detail_payment['date_checked']) ?></td>
                                        <td><?php echo date('M Y',$detail_payment['luong_cua_thang']) ?></td>
                                        <td><?php echo number_format($detail_payment['so_tien'])  ?></td>
                                        <td><?php echo number_format($detail_payment['he_so_luong'])  ?></td>
                                        <td><?php echo $detail_payment['so_gio'] ?></td>
                                        <td><?php if($detail_payment['chuyen_tien']==1){
                                            echo  "<div data-id=\"".$detail_payment['id']."\" data-column=\"chuyen_tien\" data-value=\"0\" class=\"btn btn-success tranf_confirm\">Đã Chuyển</div>";
                                        }elseif($detail_payment['chuyen_tien']==0) {
                                            echo  "<div data-id=\"".$detail_payment['id']."\" data-column=\"chuyen_tien\" data-value=\"1\" onclick=\"\" class=\"btn btn-danger tranf_confirm\">Chưa chuyển</div>" ;
                                        }
                                        ?></td>

                                    </tr>
                                    <?php $stt_payment++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="student_payment" >
                        <div class="table-responsive">
                            <table class="table" id="table_student_payment">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên Học sinh</th>
                                        <th>Số hóa đơn</th>
                                        <th>Số Giờ</th>
                                        <th>Ngày nhận</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Số tiền</th>
                                    </tr>
                                </thead>
                                <tbody>

                                        <?php $stt=1; foreach ($renew_history as $key => $value) {

                                            ?>
                                        <tr>
                                            <td>
                                                <?php echo $stt;  ?>
                                            </td>
                                            <td>
                                                <?php echo $value->ten_hoc_sinh;  ?>
                                            </td>
                                            <td>
                                                <?php  echo $value->so_hoa_don ?>
                                            </td>
                                            <td  style="color:green;font-weight:bold">
                                                <?php echo $value->so_gio." Giờ";  ?>
                                            </td>
                                            <td>
                                                <?php echo date('d-m-Y',strtotime($value->ngay_nhan));  ?>
                                            </td>
                                            <td>
                                                <?php echo date('d-m-Y',strtotime($value->ngay_bat_dau));  ?>
                                            </td>
                                            <td>
                                                <?php if ($value->so_tien!="") {
                                                echo number_format($value->so_tien). " VNĐ" ;
                                                }   ?>
                                            </td>
                                        </tr>
                                            <?php  $stt++;
                                            }
                                        ?>

                                </tbody>
                            </table>
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

<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}" ></script>
<script>
    $('#table_student_payment').DataTable({
        "paging":   true
    });
    $('#table_teacher_payment').DataTable({
        "paging":   true
    });

    // confirm tranf money
    $('.tranf_confirm').click(function (e) {
        e.preventDefault();
        let text = "Đổi trạng thái!";
        let url = "{{route('payment_update')}}";
        if(confirm(text)==true){
            let object_param={
                id:$(this).attr("data-id"),
                column:$(this).attr("data-column"),
                value:$(this).attr("data-value")
            }
            $.ajax({
                type: "GET",
                url: url,
                data: object_param,
                success: function (response) {
                    location.reload();
                }
            });
        }

    });


</script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}" ></script>
<script src="{{route('/')}}/assets/js/jquery.ui.min.js"></script>
<script src="{{route('/')}}/assets/js/calendar/moment.min.js"></script>
<script src="{{route('/')}}/assets/js/calendar/fullcalendar.min.js"></script>

@endsection
