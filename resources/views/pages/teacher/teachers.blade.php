@extends('layouts.vertical.master')
@section('title', 'Teachers')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">

@endsection

@section('breadcrumb-title')
	<h2>Dashboard <span>Intertu </span></h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item ">Trang chủ</li>
    <li class="breadcrumb-item active">Teacher</li>
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
                    <!-- form add new teacher-->
                    <button class="btn btn-primary mb-3" type="button" data-toggle="modal" data-target="#add_new_teacher">Add new teacher</button>
                    <div id="add_new_teacher" class="modal fade" tabindex="1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title" id="myLargeModalLabel">Add new teacher</h4>
                              <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                    @if ($errors->any())
                                            @foreach ($errors->all() as $error)
                                              <script> alert('{{ $error }}')</script>
                                            @endforeach
                                    @endif
                                    <form action="/teachers/add_new/" method="GET" class="dropzone dropzone-custom needsclick add-professors" id="" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input name="fullname" type="text" required="" class="form-control" placeholder="Full Name">
                                        </div>
                                        <div class="form-group">
                                            <input name="address" type="text" class="form-control" placeholder="Address (option)">
                                        </div>
                                        <div class="form-group">
                                            <input name="mobileno" class="form-control" placeholder="Mobile no. (option)">
                                        </div>
                                        <div class="form-group">
                                            <input name="birthday" id="finish" type="date" class="form-control" placeholder="Date of Birth (option)">
                                        </div>
                                        <div class="form-group">
                                            <input name="email" type="email" class="form-control" placeholder="Email Teacher">
                                        </div>

                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group res-mg-t-15">
                                                <textarea class="form-control" name="noteprof" placeholder="Note teacher"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <select class="form-control" name="gender" id="">
                                                    <option selected value="">Chọn giới tính</option>
                                                    <option value="1">Nam</option>
                                                    <option value="2">Nữ</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-form-label">Select teaching subject</div>
                                                <select name="teaching_subjects[]" style="width:350px" id="mySelect2" class="form-control js-example-placeholder-multiple col-sm-12" multiple>
                                                    @foreach ($subjects as $subject)
                                                        <option value="{{$subject->id}}">{{$subject->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 centerr">
                                                <div class="payment-adress">
                                                    <input type="submit" name="add_teacher" class="btn btn-primary waves-effect waves-light" value="Submit">
                                                </div>
                                            </div>
                                        </div>
                                </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    <!-- End add new teacher -->
                    <table id="basic-2" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Tên</th>
                                <th scope="col">R&D</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Email</th>
                                <th scope="col">Hệ số lương</th>
                                <th scope="col">Teaching Subject</th>
                                <th scope="col">Note</th>
                                <th>Tool</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teachers as $teacher)

                            <tr>
                                <td class="font-primary f-w-700">{{$teacher->fullname}}</td>
                                <td>
                                    @if($teacher->rd_team==1)
                                        <span class="badge badge-primary">R&D</span>
                                    @else
                                        <span class="badge badge-success">Part-time</span>
                                    @endif
                                </td>
                                <td>{{$teacher->phone}}</td>
                                <td>{{$teacher->email}}</td>
                                <td>
                                    @php
                                    echo number_format($teacher->hesoluong);
                                    @endphp
                                </td>
                                <td>
                                    {{-- <span >
                                        @if(isset($teacher->teaching_subject)&&$teacher->teaching_subject!='null')
                                            @foreach (json_decode($teacher->teaching_subject) as $id_subject)
                                                @foreach ($subjects as $subject)
                                                    @if($subject->id==$id_subject)
                                                    <span class="badge badge-secondary">{{$subject->name}}</span>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                    </span> --}}
                               </td>
                                <td>{{$teacher->note}}</td>
                                <td>
                                    <div class="btn-group btn-sm">
                                        <a href="teachers/detail/{{$teacher->id_teacher}}" class="btn btn-info">Detail</a>
                                        <a href="{{url('teachers/delete/'.$teacher->id_teacher)}}" onclick="return confirm('Bạn có chắc xóa giáo viên {{$teacher->fullname}}?')" class="btn btn-danger form-control">Delete</a>
                                    </div>
                                </td>
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
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}" ></script>
<script src="{{ asset('assets/js/select2/select2.full.min.js') }}" ></script>
<script src="{{ asset('assets/js/select2/select2-custom.js') }}" ></script>

@endsection
