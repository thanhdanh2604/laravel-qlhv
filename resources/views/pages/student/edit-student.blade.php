@extends('layouts.vertical.master')
@section('title', 'Students')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">

@endsection

@section('breadcrumb-title')
	<h2>Dashboard <span>Intertu </span></h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item ">Trang chủ</li>
    <li class="breadcrumb-item ">Students</li>
    <li class="breadcrumb-item active">Student detail</li>
@endsection
@section('style')
@endsection
@section('content')
<div class="container-fluid">
   <div class="row starter-main">
      <div class="col-sm-12">
         <div class="">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
                <div class="row">
                    <div class="col-lg-4">
                       <div class="card">
                          <div class="card-body">
                             <div class="theme-form">
                                <div class="row mb-2">
                                   <div class="col-auto">
                                       <img class="img-70 rounded-circle" alt=""
                                       @if($student->gender==1)
                                       src="{{route('/')}}/assets/images/user/7.jpg"
                                       @else
                                       src="{{route('/')}}/assets/images/user/6.jpg"
                                       @endif>
                                    </div>
                                   <div class="col">
                                      <h3 class="mb-1">{{$student->full_name}}</h3>
                                      <p class="mb-4"> </p>
                                   </div>
                                </div>
                                <form action="{{url('students/update/pass_student/'.$student->id_student)}}">
                                    <div class="form-group">
                                        <label class="form-label">Email-Address</label>
                                        <input class="form-control" value="{{$student->email}}" type="email" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Password</label>
                                        <input name="pass_student" class="form-control" type="password" value="password">
                                    </div>
                                    <div class="form-footer">
                                        <button href="" class="btn btn-primary btn-block btn-pill">Save password</button>
                                    </div>
                                </form>
                             </div>
                          </div>
                       </div>
                    </div>
                    <div class="col-lg-8">
                       <form class="card theme-form"
                        action="{{url('/students/update/'.$student->id_student)}}">
                           @csrf
                          <div class="card-body">
                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Full name</label>
                                        <input value="{{$student->full_name}}" name="name" type="text" required="" class="form-control" placeholder="Full Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Mã lớp (id_class)</label>
                                        <input value="{{$student->id_class}}" name="ma_lop" type="text" required="" class="form-control" placeholder="Mã lớp">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Skype</label>
                                        <input value="{{$student->skype}}" name="skype" type="text"  class="form-control" placeholder="Skype name (Option)">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Address</label>
                                        <input value="{{$student->address}}" name="address" type="text" class="form-control" placeholder="Address (option)">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Phone</label>
                                         <input value="{{$student->phone}}" name="mobileno" class="form-control" placeholder="Mobile no.">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input value="{{$student->email}}" name="emailstudent" class="form-control" placeholder="Email Student (option)">
                                    </div>

                                    <div class="form-group">
                                        <label for="">Birthday</label>
                                        <input value="{{$student->birthday}}" name="birthday" type="date" class="form-control" placeholder="Date of Birth">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                        <div class="form-group ">
                                            <label for="">Note</label>
                                            <textarea value="" class="form-control" name="notestudent" placeholder="Note">{{$student->note}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Parent Name</label>
                                            <input value="{{$student->parent_name}}" name="parentname" class="form-control" placeholder="Parent Name (option)">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Parent Phone</label>
                                            <input value="{{$student->parent_phone}}" name="numparrent" class="form-control" placeholder="Parent no. (option)">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Parent Email</label>
                                            <input value="{{$student->parent_email}}" name="emailparent" class="form-control" placeholder="Parent's Email. (option)">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Gender</label>
                                            <select value="{{$student->gender}}" name="gender" required="" class="form-control">
                                                <option value="0">Male</option>
                                                <option value="1">Female</option>
                                            </select>
                                        </div>
                                </div>
                             </div>
                            <div class="col-md-12 text-right">
                                <button class="btn btn-primary btn-pill" type="submit">Update Profile</button>
                            </div>
                          </div>
                       </form>
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
