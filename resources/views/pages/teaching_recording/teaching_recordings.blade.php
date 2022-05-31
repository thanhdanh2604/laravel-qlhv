<?php
 use App\Http\Controllers\teaching_recording\details_teaching_recording;
?>
@extends('layouts.vertical.master')
@section('title', 'Teaching recording')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">

@endsection

@section('breadcrumb-title')
	<h2>Dashboard <span>Intertu </span></h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item ">Trang chủ</li>
    <li class="breadcrumb-item active">Teaching Recording</li>
@endsection
@section('style')
@endsection
@section('content')
<div class="container-fluid">
   <div class="row starter-main">
      <div class="col-sm-12">
         <div>
            <div class="card-body">
                <div class="table-responsive">
                    <h1>Teaching Recording List</h1>
                    <!-- form add new teacher-->
                    <button class="btn btn-primary mb-3" type="button" data-toggle="modal" data-target="#add_new_teaching_recording">Add new teaching recording</button>

                    @if ($errors->any())
                            <script>
                            @foreach ($errors->all() as $error)
                             alert('{{ $error }}')
                            @endforeach
                            </script>
                    @endif
                    <div id="add_new_teaching_recording" class="modal fade" tabindex="1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title" id="myLargeModalLabel">Add new Teaching_recording</h4>
                              <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                    <form action="/teaching_recordings/add_new/" method="GET" class="dropzone dropzone-custom needsclick add-professors" id="" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-lg-12 center">
                                                <div class="form-group">
                                                    <label class="f-w-900"  for="">Teaching Recording Name:</label>
                                                    <input type="text" name="name" class="form-control">
                                                </div>
                                                <div class="form-group m-t-15 m-checkbox-inline mb-0 custom-radio-ml">
                                                    <label class="f-w-900"  for="">Type Class:</label>
                                                    <div class="radio radio-info">
                                                        <input selected id="radioinline1" type="radio" name="type_class" value="1">
                                                        <label class="mb-0 text-info f-w-700" for="radioinline1">P-P</label>
                                                    </div>
                                                    <div class="radio radio-primary">
                                                        <input id="radioinline2" type="radio" name="type_class" value="2">
                                                        <label class="mb-0 text-primary f-w-700" for="radioinline2">Group</label>
                                                    </div>
                                                    <div class="radio radio-success">
                                                        <input id="radioinline3" type="radio" name="type_class" value="0">
                                                        <label class="mb-0 text-success f-w-700" for="radioinline3">Trial</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="f-w-900" for="">Chọn học sinh: </label>
                                                    <div id="block_select_group" style="display:none">
                                                        <select name="group_student[]"style="width:500px" id="group_class" class="js-example-placeholder-multiple col-sm-12" multiple="multiple">
                                                            @foreach ($students as $id_student =>$name)
                                                            <option value="{{$id_student}}">{{$name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div id="block_select_pp" style="">
                                                        <select onchange="ajaxShowIdclass(this.value)" placehold id="p-p_class" name="student" style="width:500px" class="js-example-placeholder-multiple col-sm-12">
                                                            <option selected disabled>Chọn học sinh: </option>
                                                            @foreach ($students as $id_student =>$name)
                                                            <option value="{{$id_student}}">{{$name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>
                                                <div id="block_ma_lop" class="form-group">
                                                    <label class="f-w-900"  for="">Mã lớp:</label>
                                                    <input class="form-control" type="text" name="ma_lop" id="ma_lop">
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" name="add_teaching_recording" class="btn btn-primary waves-effect waves-light center" value="Submit">
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    <!-- End add new teacher -->
                    <table id="basic-2" class="table keytable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Type Class</th>
                                <th scope="col">Active</th>
                                <th scope="col">Student</th>
                                <th scope="col">Teacher</th>
                                <th scope="col">ID Class</th>
                                <th scope="col">Time left</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $stt=1; @endphp
                            @foreach ($teaching_recordings as $teaching_recording)
                            <tr>
                                <td>{{$stt;}}</td>
                                @php
                                    $stt++;
                                @endphp
                                <td class="font-primary f-w-700">{{$teaching_recording->name}}</td>
                                <td>
                                    @switch($teaching_recording->type)
                                        @case(0)
                                        <span class="badge badge-success">TRAIL</span>
                                       @break
                                        @case(1)
                                            <span class="badge badge-info">P-P</span>
                                            @break
                                        @case(2)
                                            <span class="badge badge-secondary">Group</span>
                                            @break
                                        @default
                                    @endswitch
                                </td>
                                <td>
                                    <div class="media-body text-right">
                                        <label class="switch">
                                          <input data-id="{{$teaching_recording->id}}" id="finish_{{$stt}}" type="checkbox"
                                          @if($teaching_recording->finish==1)
                                          checked=""
                                          @endif
                                          ><span class="switch-state"></span>
                                        </label>
                                    </div>

                                </td>
                                <td>

                                    @switch($teaching_recording->type)
                                        @case(0)
                                            @php
                                             if(isset($students[$teaching_recording->id_student])){
                                                echo "<a target=\"__blank\" href=\"students/detail/".$teaching_recording->id_student."\"><span class=\"badge badge-dark\">".$students[$teaching_recording->id_student]."</span></br></a>";
                                                break;
                                             }
                                            @endphp
                                        @break
                                        @case(1)
                                            @php
                                                if(isset($students[$teaching_recording->id_student])){
                                                    echo "<a target=\"__blank\" href=\"students/detail/".$teaching_recording->id_student."\"><span class=\"badge badge-dark\">".$students[$teaching_recording->id_student]."</span></br></a>";
                                                }
                                                break;
                                            @endphp
                                            @break
                                        @case(2)
                                            @php

                                                $array_student = json_decode($teaching_recording->id_student);
                                                //var_dump($teachers[1]);
                                                foreach ($array_student as $teaching_id_student) {
                                                    echo "<a href=\"students/detail/".$teaching_id_student."\"><span class=\"badge badge-secondary\">".$students[$teaching_id_student]."</span></br></a>";
                                                }

                                            @endphp
                                            @break
                                        @default

                                    @endswitch
                                </td>
                                <td>
                                    @php
                                        if($teaching_recording->teaching_history==null){
                                            echo "Chưa tạo lịch học!";
                                        }else{
                                            foreach (json_decode($teaching_recording->teaching_history) as $value){
                                                if(isset($teachers[$value->ma_giao_vien])){
                                                    echo "<a target=\"__blank\" href=\"teachers/detail/".$value->ma_giao_vien."\"><span class=\"badge badge-warning\">".$teachers[$value->ma_giao_vien]."</span></a></br>";
                                                }
                                            }

                                        }
                                    @endphp
                                </td>
                                <td>
                                    {{$teaching_recording->ma_lop}}
                                </td>
                                <td>
                                    @if($teaching_recording->ma_lop!=null)
                                    @php
                                        $array_time_study = details_teaching_recording::getStudyInfo($teaching_recording->id);
                                        if($array_time_study['time_left']<=6){
                                            echo "<span class=\"badge badge-danger\">".$array_time_study['time_left']." Hours</span>";
                                        }else{
                                            echo "<span class=\"badge badge-success\">".$array_time_study['time_left']." Hours</span>";
                                        }
                                    @endphp

                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-sm">
                                        <a href="teaching_recordings/detail/{{$teaching_recording->id}}" class="btn btn-info">Detail</a>
                                        <a href="{{url('teaching_recordings/delete/'.$teaching_recording->id)}}" onclick="return confirm('Bạn có chắc xóa nhật ký giảng dạy {{$teaching_recording->name}}?')" class="btn btn-danger form-control">Delete</a>
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
<script>
    //bắt sự kiện ajax finish teaching Recording
    var node_finish = document.querySelectorAll('[type=checkbox]')
    node_finish.forEach(element => {
        //
        var id = element.getAttribute('data-id')
        element.addEventListener("change",function(){
            if(this.checked){
                ajaxFinishTR(id,0)
            }else{
                ajaxFinishTR(id,1)
            }
        });
    });
    // Bắt sự kiện chọn PP hay Group trong add teaching recording
    var node_name_radio_type = document.getElementsByName("type_class")
    node_name_radio_type.forEach(element =>{
        element.addEventListener("change",function(){
            if(this.checked){
                // Lấy Tự động chọn mã lớp
                switch (this.value) {
                    case 1:
                        document.getElementById("block_select_pp").style.display="block"
                        document.getElementById("ma_lop").value = ""
                        document.getElementById("block_select_group").style.display="none"
                        break;
                    case 0:
                        document.getElementById("block_select_pp").style.display="block"
                        document.getElementById("block_select_group").style.display="none"
                        document.getElementById("ma_lop").value = "TRAIL"
                        break;
                    case 2:
                        document.getElementById("block_select_group").style.display="block"
                        document.getElementById("block_select_pp").style.display="none"
                        document.getElementById("ma_lop").value = "GROUP"
                    default:
                        break;
                }
            }
        })
    })
    // Bắt sự kiện đổi học sinh trong P-P class để đổi mã lớp

    function ajaxShowIdclass(id_student){
        console.log(id_student);
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {

            document.getElementById('ma_lop').value = this.responseText
        }
        xhttp.open("GET", "./students/select_column_student/"+id_student+"/id_class", true);
        xhttp.send();
    }
    function ajaxFinishTR(id,value) {
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
           console.log(this.responseText)
        }
        xhttp.open("POST", "./teaching_recordings/edit/finish/"+id+"?finish="+value, true);
        xhttp.send();
    }

</script>
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}" ></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}" ></script>
<script src="{{ asset('assets/js/select2/select2.full.min.js') }}" ></script>
<script src="{{ asset('assets/js/select2/select2-custom.js') }}" ></script>

@endsection

