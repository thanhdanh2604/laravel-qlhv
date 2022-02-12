<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <meta name="author" content="pixelstrap">
      <link rel="icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon">
      <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon">
      <title>Intertu - QLHV</title>


      @include('layouts.vertical.css')
      @yield('style')
   </head>
   <body>
      <!-- Loader starts-->
      <div class="loader-wrapper">
         <div class="typewriter">

            <h1>Intertu Admin Loading..</h1>

         </div>
      </div>
      <!-- Loader ends-->
      <!-- page-wrapper Start-->
      <div class="page-wrapper vertical">
         <!-- Page Header Start-->
         @include('layouts.vertical.header')
         <!-- Page Header Ends   -->
         <!-- vertical menu start-->
         @include('layouts.vertical.sidebar')
         <!-- vertical menu ends-->
         <!-- Page Body Start-->
         <div class="page-body-wrapper">

            {{-- <!-- Right sidebar Start-->
            @include('layouts.vertical.chat_sidebar') --}}
            <!-- Right sidebar Ends-->
            <div class="page-body vertical-menu-mt">

            <!-- Right sidebar Start-->
            @include('layouts.vertical.chat_sidebar')
            <!-- Right sidebar Ends-->
            <div class="page-body vertical-menu-mt">
               <div class="container-fluid">
                  <div class="page-header">
                     <div class="row">
                        <div class="col-lg-6 main-header">
                           @yield('breadcrumb-title')
                           <h6 class="mb-0">admin panel</h6>
                        </div>
                        <div class="col-lg-6 breadcrumb-right">
                           <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ route('/') }}"><i class="pe-7s-home"></i></a></li>
                              @yield('breadcrumb-items')
                           </ol>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Container-fluid starts-->
               @yield('content')
               <!-- Container-fluid Ends-->
            </div>
         </div>
      </div>
      @include('layouts.vertical.script')
   </body>
</html>
