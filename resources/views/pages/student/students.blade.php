@extends('layouts.vertical.master')
@section('title', 'Students')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">

@endsection

@section('breadcrumb-title')
	<h2>Student <span> List </span></h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item ">Trang chủ</li>
    <li class="breadcrumb-item active">Students</li>
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
                    <h1>Student List</h1>
                    <!-- form add new student-->
                    <button class="btn btn-primary mb-3" type="button" data-toggle="modal" data-target="#add_new_student">Add new student</button>
                    <div id="add_new_student" class="modal fade" tabindex="1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title" id="myLargeModalLabel">Add new Student</h4>
                              <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                    @if ($errors->any())
                                        @foreach ($errors->all() as $error)
                                        <script> alert('{{ $error }}')</script>
                                        @endforeach
                                    @endif
                                    <form action="/students/add_new/" method="GET" class="dropzone dropzone-custom needsclick add-professors" id="demo1-upload">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                <input name="name" type="text" required="" class="form-control" placeholder="Full Name">
                                            </div>
                                            <div class="form-group">
                                                <input name="ma_lop" type="text" required="" class="form-control" placeholder="Mã lớp">
                                            </div>
                                            <div class="form-group">
                                                <input name="skype" type="text"  class="form-control" placeholder="Skype name (Option)">
                                            </div>
                                            <div class="form-group">
                                                <input name="address" type="text" class="form-control" placeholder="Address (option)">
                                            </div>
                                            <div class="form-group">
                                                 <input name="mobileno" class="form-control" placeholder="Mobile no.">
                                            </div>
                                            <div class="form-group">
                                                <input name="emailstudent" class="form-control" placeholder="Email Student (option)">
                                            </div>

                                            <div class="form-group">
                                                <input name="birthday" type="date" class="form-control" placeholder="Date of Birth">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group res-mg-t-15">
                                            <textarea class="form-control" name="notestudent" placeholder="Note"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <input name="parentname" class="form-control" placeholder="Parent Name (option)">
                                            </div>
                                            <div class="form-group">
                                                <input name="numparrent" class="form-control" placeholder="Parent no. (option)">
                                            </div>
                                            <div class="form-group">
                                                <input name="emailparent" class="form-control" placeholder="Parent's Email. (option)">
                                            </div>
                                            <div class="form-group">
                                                <select name="gender" required="" class="form-control">
                                                <option value="none" selected="" disabled="">Select Gender</option>
                                                <option value="0">Male</option>
                                                <option value="1">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="payment-adress">
                                                    <input type="submit" name="add_student" class="btn btn-primary waves-effect waves-light" value="Submit">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    <!-- End add new student -->
                    <table id="basic-2" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Tên</th>
                                <th scope="col">ID Student</th>
                                <th scope="col">Student phone</th>
                                <th scope="col">Parent name</th>
                                <th scope="col">Parent phone</th>
                                <th scope="col">Note</th>
                                <th>Tool</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td><span class="font-primary f-w-700">{{$student->full_name}}</span></td>
                                    <td>{{$student->id_class}}</td>
                                    <td>{{$student->phone}}</td>
                                    <td><span class="text-primary f-w-700">{{$student->parent_name}}</span></td>
                                    <td>{{$student->parent_phone}}</td>
                                    <td>{{$student->note}}</td>
                                    <td>
                                        <div class="btn-group btn-sm">
                                            <a href="students/detail/{{$student->id_student}}" class="btn btn-info">Detail</a>
                                            <a href="{{url('students/delete/'.$student->id_student)}}" onclick="return confirm('Bạn có chắc xóa Học sinh {{$student->full_name}}?')" class="btn btn-danger form-control">Delete</a>
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


@endsection
