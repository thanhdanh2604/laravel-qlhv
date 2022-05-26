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
                   <h5>Calendar</h5>
                   <span>Full calendar</span>
                </div>
                <div class="card-body">
                   <div class="row">
                      <div class="col-md-12">
                         <div id="cal-event-colors"></div>
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
{{-- <script src="{{route('/')}}/assets/js/calendar/fullcalendar-custom.js"></script> --}}
<script>
    $('#cal-event-colors').fullCalendar({
            header: {
            right: 'prev,next today',
            center: 'title',
            left: 'month,basicWeek,basicDay'
            },
            defaultDate: '2016-06-12',
            editable: true,
            droppable: true,
            eventLimit: true,
            select: function(start, end, allDay) {
                var title = prompt('Event Title:');
                if (title) {
                    $('#cal-basic-view').fullCalendar('renderEvent',
                    {
                        title: title,
                        start: start._d,
                        end: end._d,
                        allDay: allDay
                    },
                    true
                    );
                }
                $('#cal-basic-view').fullCalendar('unselect');
            },
            events: [
            {
                title: 'Long Event',
                start: '2016-06-07',
                end: '2016-06-10'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2016-06-09T16:00:00'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2016-06-16T16:00:00'
            },
            {
                title: 'Conference',
                start: '2016-06-11',
                end: '2016-06-13'
            }
            ]
        })
</script>
@endsection
