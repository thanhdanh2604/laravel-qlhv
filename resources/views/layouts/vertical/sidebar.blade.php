<div class="vertical-menu-main">
   <nav id="main-nav">
      <!-- Sample menu definition-->
      <ul class="sm pixelstrap" id="main-menu">
         <li>
            <div class="text-right mobile-back">Back<i class="fa fa-angle-right pl-2" aria-hidden="true"></i></div>
         </li>

         <li>
             <a href="{{route('/')}}"> Dashboard</a></li>
         {{-- <li>
            <a href="{{route('calendar')}}"> Calendar</a>
         </li> --}}
         <li>
            <a href="{{route('teachers')}}">Teachers</a>
         </li>
         <li>
            <a href="{{route('students')}}">Students</a>
         </li>
         <li>
            <a href="{{route('teaching_recordings')}}">Teaching Recording</a>
         </li>
         <li>
            <a href="#">Library</a>
         </li>
         <li>
            <a href="{{route('subjects')}}">Subject</a>
         </li>
         <li>
            <a href="#"> Admin & Payment</a>

            <ul>
                <li><a href="{{route('payment')}}">Payment</a></li>
                <li><a href="{{route('teaching_statistics')}}">Teaching Statistics</a></li>
                <li><a href="#">Management Member</a></li>
            </ul>
         </li>
      </ul>
   </nav>
</div>
