@extends('layouts.vertical.master')
@section('title', 'Payment')
@section('css')

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

             </div>
          </div>
       </div>

 </div>
@endsection

@section('script')

{{-- <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}" ></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}" ></script> --}}
<script src="{{route('/')}}/assets/js/jquery.ui.min.js"></script>
<script src="{{route('/')}}/assets/js/calendar/moment.min.js"></script>
<script src="{{route('/')}}/assets/js/calendar/fullcalendar.min.js"></script>

@endsection
