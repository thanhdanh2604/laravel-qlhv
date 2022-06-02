<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Intertu Teaching Report</title>
  {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> --}}

  <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet"> -->
  <style>

    body{
        color:#1E4612;
        /* font-family: 'Roboto', sans-serif; */
        font-family: DejaVu Sans;
        display: grid;
        justify-content: center;
      }
      .input_start_date{
        margin-top:20px;
      }
      .header{
        border-bottom: 5px solid green;
      }
      .title h1{
        color: #1E4612;
        padding: 5px;
        display: inline-block;
        border-radius: 10px;
      }
      .header .header_img {
        clip-path: circle(56.1% at 20% 10%);
        background-color: #1E4612;
        height: 100px;
      }
      .header_img img{
        width: 60%;
        margin-top:20px;
      }
      h3{
        color:#1E4612;
      }
      table{
        width: 100%;

      }
      thead tr {
        background-color: #1E4612;
        color: white;
      }
      table .table_content{
        border-collapse: collapse;
      }
      th,td{
        padding:10px;
        border: 1px solid #1E4612;
        border-collapse: collapse;
      }
      [colspan="2"]{
        font-weight: bold;
      }
      tfoot{
        font-weight: bold;

      }
      div#page_right {
        border-left: 1px solid #1E4612;
        padding-left:5px;
      }
      .report_layout{
        border:1px solid #1E4612;
      }
      .btn-export{
        color: blue;
        font-size: 20px;
        font-weight: bold;
        margin-right: 10px;
        position: absolute;
        left: 45px;
      }
      .btn-export:hover{
        cursor: pointer;
      }
      .header div{
        display: inline-block;
      }
      .header_package{
        text-align: center;
      }
      .title{
        width: 100%;
        text-align: center;
      }
      .header{
        display: grid;
        grid-template-columns: 20% 20% 40% 20%;
      }
      .input_report{
        display: flex;
      justify-content: space-around;
      padding: 10px;
      margin-bottom: 10px;
      border:1px solid;
      }
      .package_hour{
        font-size: 30px;
        font-weight: bold;
      }
      .lesson_note,.comment_note,.notes{
        font-style: italic;
      }
      .lesson_note:hover,.comment_note:hover,.notes:hover{
        cursor: pointer;
      }
      i{
        font-size: 20px!important;
        color:red;
      }
  </style>
</head>
<body>
  <div id="main_content">
    <div class="header">
        {{-- <div class="header_img">
          <img src="/img/logo-edu(trang).png" alt="Logo intertu">
        </div> --}}
        <table>
            <tbody>
                <tr>
                    <td scope="row">
                        <div class="header_info_student">
                        <p><strong>ID:</strong> <?php echo $data['ma_lop'] ?></p>
                        <p><strong>Student:</br></strong> <?php  echo $student_name ?></p>
                      </div>
                    </td>
                    <td>
                        <div class="header_info_subject">
                            <p><strong>Class name:</br></strong> <?php echo $data['name'] ?></p>
                            <div><strong>Duration: </strong><?php echo date('d/m/Y',$start).' - '.date('d/m/Y',$end) ?></div>
                          </div>
                    </td>
                    <td>
                        <div class="header_package">
                            <div class="package_hours">
                              <?php if($month==''){ ?>
                              <strong>Package: <p></strong>
                              <span class="package_hour"><?php echo $amount_of_hours_last_package ?></span>
                              <p>hours</p>
                              <?php }else{
                                echo "<span class=\"package_hour\">Report Monthly</span>";
                              } ?>
                            </div>
                          </div>
                    </td>
                </tr>
            </tbody>
        </table>
      </div>
    <div class="title">
        <h1>Intertu Teaching Report</h1>
    </div>
    <div class="table_content">
        <table class="table table-bordered table-hover" style="text-align:center;border-collapse:collapse;">
          <thead>
            <tr>
              <th>No</th>
              <th>Date</th>
              <th>Time</th>
              <th>Subject</th>
              <th>Lesson</th>
              <th>Comments</th>
              <th>Teacher</th>
              <th>Hours</th>
              <th>Notes</th>
            </tr>
          </thead>
          <tbody>
            <?php $stt=1;
                $total_hous = 0;
                foreach ($array_new_teaching_history as $time => $chi_tiet_buoi_hoc) {
                  // Kiểm tra tất cả những giờ đã tính cho bé và thời gian đó phải lớn hơn 0
                  if(isset($chi_tiet_buoi_hoc->hours)&&$chi_tiet_buoi_hoc->hours>0){
               ?>
                  <tr>
                    <td><?php echo $stt; ?></td>
                    <td><?php echo $chi_tiet_buoi_hoc->date ?></td>
                    <td><?php echo $chi_tiet_buoi_hoc->starttime?></td>

                    <td><?php echo $chi_tiet_buoi_hoc->subject_name;?></td>
                    <td>
                      <span class="lesson_note">
                        <?php echo isset($chi_tiet_buoi_hoc->lesson_note)?$chi_tiet_buoi_hoc->lesson_note:'';?>
                      </span>
                    </td>
                    <td>
                      <span>
                        <?php echo isset($chi_tiet_buoi_hoc->note_comment)?$chi_tiet_buoi_hoc->note_comment:'';?>
                      </span>
                    </td>
                    <td><?php echo $chi_tiet_buoi_hoc->teacher_name;?></td>
                    <td class="hour"><?php
                      echo $chi_tiet_buoi_hoc->hours;
                      $total_hous+=$chi_tiet_buoi_hoc->hours;
                     ?></td>
                    <td>
                        <span >
                          <?php echo isset($chi_tiet_buoi_hoc->notes)?$chi_tiet_buoi_hoc->notes:'';?>
                        </span>

                    </td>
                  </tr>
            <?php $stt++; } }?>
            <tr>
              <td colspan=7><strong>Total hours of studying</strong></td>
              <td colspan=2 id="total_hours"><?php echo $total_hous; ?></td>
            </tr>
            <tr>
              <td colspan=7><strong>Number remaining hours of the current package</strong></td>
              <td colspan=2 id="time_left"><?php echo $amount_of_hours_last_package-$total_hous ?></td>
            </tr>
          </tbody>
        </table>
    </div>
  </div>
</body>
</html>
