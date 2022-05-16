@extends('layouts.vertical.master')
@section('title', 'Dashboard')
@section('css')
<link rel="stylesheet" type="text/css" href="{{route('/')}}/assets/css/calendar.css">
@endsection

@section('breadcrumb-title')
	<h2>Dashboard <span>Intertu </span></h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item active">Calendar</li>
@endsection
@section('style')
@endsection
@section('content')
<div class="container-fluid">
    <div class="calendar-wrap">
       <div class="row">
          <div class="col-sm-12">
             <div class="card">
                <div class="card-header">
                   <h5>Basic</h5>
                   <span>This is the basic example having navigation button to navigate next and previous months and today button. This basic example lists all the events on the calendar.</span>
                </div>
                <div class="card-body">
                   <div class="row">
                      <div class="col-md-12">
                         <div id="cal-basic"></div>
                      </div>
                   </div>
                </div>
             </div>
             <div class="card">
                <div class="card-header">
                   <h5>Basic Views</h5>
                   <span>This is the basic example having navigation buttons as well as month, week and day views. In this example the option to change your view to a basicWeek or basicDay view. In the Basic Week or Basic Day View events are listed all together.</span>
                </div>
                <div class="card-body">
                   <div class="row">
                      <div class="col-md-12">
                         <div id="cal-basic-view"></div>
                      </div>
                   </div>
                </div>
             </div>
             <div class="card">
                <div class="card-header">
                   <h5>Agenda Views</h5>
                   <span>The following example demonstrates agenda views and the defaultView option is set to agendaWeek.</span>
                </div>
                <div class="card-body">
                   <div class="row">
                      <div class="col-md-12">
                         <div id="cal-agenda-view"></div>
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
{{-- <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}" ></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}" ></script> --}}
<script src="{{route('/')}}/assets/js/jquery.ui.min.js"></script>
<script src="{{route('/')}}/assets/js/calendar/moment.min.js"></script>
<script src="{{route('/')}}/assets/js/calendar/fullcalendar.min.js"></script>
<script src="{{route('/')}}/assets/js/calendar/fullcalendar-custom.js"></script>
@endsection
