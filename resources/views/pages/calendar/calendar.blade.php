@extends('layouts.vertical.master')
@section('title', 'Dashboard')
@section('css')
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/calendar.css">
@endsection

@section('breadcrumb-title')
	<h2>Dashboard <span>Intertu </span></h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item active">Trang chủ</li>
@endsection
@section('style')
@endsection
@section('content')
<div class="container-fluid">
   <div class="row starter-main">
      <div class="col-sm-12">

      </div>
   </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}" ></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}" ></script>

<script src="{{route('/')}}/assets/js/jquery.ui.min.js"></script>
<script src="{{route('/')}}/assets/js/calendar/moment.min.js"></script>
<script src="{{route('/')}}/assets/js/calendar/fullcalendar.min.js"></script>
<script src="{{route('/')}}/assets/js/calendar/fullcalendar-custom.js"></script>

@endsection
