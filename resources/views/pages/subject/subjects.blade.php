<?php
 use App\Http\Controllers\teaching_recording\details_teaching_recording;
?>
@extends('layouts.vertical.master')
@section('title', 'Subject')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">

@endsection

@section('breadcrumb-title')
	<h2>Dashboard <span>Intertu </span></h2>
@endsection

@section('breadcrumb-items')
	<li class="breadcrumb-item ">Trang chủ</li>
    <li class="breadcrumb-item active">Subjects</li>
@endsection
@section('style')
@endsection
@section('content')
<div class="container-fluid">
   <div class="row starter-main">
      <div class="col-sm-12">
        <div class="card-body">
            <div class="row ">
                <div style="margin-left: 10px" class="col-lg-8 white-box">
                    <table class="table" id="table-class">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Subject name</th>
                                <th>Tool</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $stt = 1; foreach ($subjects as $key => $value) { ?>

                            <tr>
                                <td><?php echo $stt; ?></td>

                                <td>
                                    <?php echo $value->name; ?>
                                        <span style="margin-left:5px ;padding:3px; border:1px solid green;border-radius:3px" data-toggle="collapse" href="#edit_name_subject_<?php echo $value->id; ?>" role="button" aria-expanded="false" aria-controls="collapseExample" class="glyphicon glyphicon-pencil btn-success"></span>

                                    <div class="collapse" id="edit_name_subject_<?php echo $value->id; ?>">
                                        <input type="text" id="name_subject_<?php echo $value->id; ?>" value="<?php echo $value->name; ?>">
                                        <span onclick="edit_subject(<?php echo $value->id; ?>)" class="btn-sm btn-success">Edit</span>
                                    </div>

                                </td>
                                <td> <div class="btn btn-danger"> Delete</div></td>
                            </tr>
                            <?php $stt++;} ?>
                        </tbody>
                    </table>

                </div>
                <div style=" margin-left:10px;position: sticky;" class="col-lg-3 white-box">
                    <div id="add-subject">
                        <h3> Add more Subject</h3>
                        <form action="subject.php" method="GET" accept-charset="utf-8">
                            <div class="form-group">
                                <label>Subject Name:</label>
                                <input id="subject_name" class="form-control" type="text" name="subject-name" value="" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Note: </label>
                                <input class="form-control" type="text" name="des-subject" value="" placeholder="">
                            </div>
                            <input name="add_button" class="btn btn-success" type="submit">
                        </form>
                    </div>
                    <hr>

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

