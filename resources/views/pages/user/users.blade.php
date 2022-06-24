<?php
 use App\Http\Controllers\teaching_recording\details_teaching_recording;
?>
@extends('layouts.vertical.master')
@section('title', 'Teaching recording')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}"> -->

@endsection

@section('breadcrumb-title')
	<h2>Dashboard <span>Intertu </span></h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item ">Trang chủ</li>
  <li class="breadcrumb-item active">User management</li>
@endsection
@section('style')
@endsection
@section('content')
<div class="container-fluid">
   <div class="row starter-main">
      <div class="col-sm-12">
            <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th>STT</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Password</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $stt=1; foreach($data_users as $user){ ?>
                    <tr>
                      <td><?php echo $stt; ?></td>
                      <td><?php echo $user->name ?></td>
                      <td><?php echo $user->email ?></td>
                      <td>
                          <button type="button" class="btn btn-info">Edit</button>
                          <button class="btn btn-warning">Reset password</button>
                          <button type="button" class="btn  btn-danger">Delete</button>
                      </td>
                    </tr>
                    <?php $stt++; } ?>
                  </tbody>
                </table>
            </div>
      </div>
   </div>
</div>
@endsection

@section('script')

<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}" ></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}" ></script>
<!-- <script src="{{ asset('assets/js/select2/select2.full.min.js') }}" ></script>
<script src="{{ asset('assets/js/select2/select2-custom.js') }}" ></script> -->

@endsection

