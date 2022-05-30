@extends('layouts.vertical.master')
@section('title', 'Teachers')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">

@endsection

@section('breadcrumb-title')
	<h2>Teaching <span>Statistics </span></h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item ">Trang chủ</li>
	<li class="breadcrumb-item ">Payment</li>
    <li class="breadcrumb-item active">Teaching Statistics</li>
@endsection
@section('style')
@endsection
@section('content')
<div class="container-fluid">
   <div class="row starter-main">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <h1>Teacher List</h1>
                    <!-- End add new teacher -->
                    <table id="table_teaching_statistics" class="table">
                        <thead>
                            <tr>
                                <th>Full name</th>
                                <th>Phone</th>
                                <th>Salari (per hours)</th>
                                <th>Teaching detail</th>
                                <th>Teaching Hours (<?php echo date('M Y',strtotime('last month')) ?>) </th>
                                <th>Salaries (<?php echo date('M Y',strtotime('last month')) ?>)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teachers as $teacher)

                            <tr>
                                <td class="font-primary f-w-700">
                                    <a target="__blank" href="{{route('teacher_detail', ['id' =>$teacher->id_teacher])}}">{{$teacher->fullname}}</a></td>
                                <td>
                                    {{$teacher->phone}}
                                </td>
                                <td>
                                    @php
                                    echo number_format($teacher->hesoluong);
                                    @endphp
                                </td>
                                <td>

                                    <a href="{{route('teaching_details', ['id_teacher' => $teacher->id_teacher])}}" class="btn btn-info">Chi tiết</a>
                                </td>
                                <td class="txt-primary f-w-900">
                                    {{isset($teaching_hours[$teacher->id_teacher])?$teaching_hours[$teacher->id_teacher]:0}} giờ
                                </td>
                                <td class="txt-success f-w-900">{{number_format((isset($teaching_hours[$teacher->id_teacher])?$teaching_hours[$teacher->id_teacher]:0)*$teacher->hesoluong)}} </td>
                            </tr>

                            @endforeach

                        </tbody>
                    </table>

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
    $('#table_teaching_statistics').DataTable({
        "paging":   true,
        "order": [[5, 'desc']],
    });
</script>
{{-- <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}" ></script> --}}
<script src="{{ asset('assets/js/select2/select2.full.min.js') }}" ></script>
<script src="{{ asset('assets/js/select2/select2-custom.js') }}" ></script>

@endsection
