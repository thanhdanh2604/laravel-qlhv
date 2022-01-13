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
    <li class="breadcrumb-item ">Teachers</li>
    <li class="breadcrumb-item active">Teacher detail</li>
@endsection
@section('style')
@endsection
@section('content')
<div class="container-fluid">
   <div class="row starter-main">
      <div class="col-sm-12">
         <div class="card">
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
                                       @if($teacher->gender==1)
                                       src="{{route('/')}}/assets/images/user/7.jpg"
                                       @else
                                       src="{{route('/')}}/assets/images/user/6.jpg"
                                       @endif>
                                    </div>
                                   <div class="col">
                                      <h3 class="mb-1">{{$teacher->fullname}}</h3>
                                      <p class="mb-4">
                                            <span class="badge badge-danger">
                                                @if ($teacher->rd_team==1)
                                                    R&D
                                                @else
                                                    Part-time
                                                @endif
                                            </span>
                                        </p>
                                   </div>
                                </div>
                                <form action="{{url('teachers/update/pass_prof/'.$teacher->id_teacher)}}">
                                    <div class="form-group">
                                        <label class="form-label">Email-Address</label>
                                        <input class="form-control" value="{{$teacher->email}}" type="email" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Password</label>
                                        <input name="pass_prof" class="form-control" type="password" value="password">
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
                        action="{{url('/teachers/update/'.$teacher->id_teacher)}}">
                           @csrf
                          <div class="card-body">
                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-row form-group">
                                        <label>Full name</label>
                                        <input name="fullname" required="" class="form-control" placeholder="Full Name" value="{{$teacher->fullname}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input name="address" class="form-control" placeholder="Address" value="{{$teacher->address}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input name="mobileno" class="form-control" placeholder="Mobile no." value="{{$teacher->phone}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Birthday</label>
                                        <input name="birthday" id="finish" type="date" class="form-control" placeholder="Date of Birth" value="{{$teacher->birthday}}">
                                    </div>
                                    <div class="form-row">
                                        <label>Email</label>
                                        <input name="email" type="email" class="form-control" placeholder="Email Teacher" value="{{$teacher->email}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h6 class="form-label">Teaching Subject</h6>
                                        <select name="teaching_subjects[]" style="width:350px" id="mySelect3" class="form-control js-example-placeholder-multiple col-sm-12" multiple>
                                            @foreach ($subjects as $subject)
                                                @if(isset($teacher->teaching_subject)&&$teacher->teaching_subject!='null')
                                                    @foreach(json_decode($teacher->teaching_subject) as $id_subject)
                                                        @if($subject->id==$id_subject)
                                                            <option selected value="{{$subject->id}}">{{$subject->name}}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            <option value="{{$subject->id}}">{{$subject->name}}</option>
                                            @endforeach
                                         </select>
                                     </div>
                                        <div class="form-group res-mg-t-15">
                                            <label>Note Teacher</label>
                                            <textarea class="form-control" name="noteprof" placeholder="Note teacher">{{$teacher->note}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label >Hệ số lương</label>
                                            <input style="border-color:#fd517d" value="{{$teacher->hesoluong}}" class="form-control" type="text" name="hesoluong" id="">
                                        </div>
                                        <div class="form-row form-group">
                                            <label>Gender</label>
                                            <select name="gender" class="form-control">
                                                <option value="0" @if ($teacher->gender==0)
                                                    selected
                                                @endif>Male</option>
                                                <option value="1" @if ($teacher->gender==1)
                                                    selected
                                                @endif>Female</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="checkbox checkbox-primary">
                                                <input
                                                @if($teacher->rd_team==1)
                                                checked
                                                @endif name="rd_team" id="checkbox-primary-1" type="checkbox">
                                                <label for="checkbox-primary-1">R&D Team</label>
                                              </div>
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
