<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>Intertu Teaching Report</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <style>
    body{
        color:#1E4612;
        font-family: Roboto;
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
      table{
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
  <div><p id="error_display" style="color:red;font-style:italic"></p></div>
  <div class="input_report">
    <div>
      <label for="">Monthly Report </label><input type="month" name="pick_month" >
    </div>
   <div>
    <button id="current_package_report" type="button"> Current Package Report </button>
   </div>
    <div>
      <a href="{{route('export_report',['id'=>$id_nkgd])}}" target="_blank" rel="noopener noreferrer">Export PDF</a>
    </div>
    <div>
      <a href="{{route('teaching_recording_detail',['id'=>$id_nkgd])}}">Đi đến nhật ký giảng dạy</a>
    </div>
    <div>
      <label for="">Thời gian còn lại thực tế:</label> <strong><?php
       if(is_array($time_left)){

        echo end($time_left);
       }else{ echo $time_left.' Giờ';}
       ?></strong>
    </div>
  </div>
  <div id="main_content">
    <div class="header">
        <div class="header_img">
          <img src="{{asset('assets/images/image.png')}}/img/logo-edu(trang).png" alt="Logo intertu">
        </div>
        <div class="header_info_student">
          <p><strong>ID:</strong> <?php echo $data['ma_lop'] ?></p>
          <p><strong>Student:</br></strong> <?php  echo $student_name ?></p>
        </div>
        <div class="header_info_subject">
          <p><strong>Class name:</br></strong> <?php echo $data['name'] ?></p>
          <div><strong>Duration: </strong><?php echo date('d/m/Y',$start).' - '.date('d/m/Y',$end) ?></div>
        </div>
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
                      <i class="material-icons lesson_note">mode_edit</i>
                     
                      <div style="display:none" class="block_edit">
                        <textarea id="lesson_note_content_<?php echo $chi_tiet_buoi_hoc->date."_".$stt; ?>" cols="30" ><?php echo isset($chi_tiet_buoi_hoc->lesson_note)?$chi_tiet_buoi_hoc->lesson_note:'';?></textarea>
                        <button class="save_lesson_note" stt="<?php echo $stt; ?>" date="<?php echo $chi_tiet_buoi_hoc->date;?>" id_nkgd="<?php echo $id_nkgd; ?>" id_subject="<?php echo $chi_tiet_buoi_hoc->id_subject?>" id_teacher="<?php echo $chi_tiet_buoi_hoc->id_prof ?>">Edit</button>
                      </div>
                      <p style="font-size: 12px;color:red" id="error_lesson_note_<?php echo $chi_tiet_buoi_hoc->date."_".$stt; ?>"></p>
                    </td>
                    <td>
                      <span>
                        <?php echo isset($chi_tiet_buoi_hoc->note_comment)?$chi_tiet_buoi_hoc->note_comment:'';?>
                      </span>
                      <i class="material-icons comment_note">mode_edit</i>
                      <div style="display:none" class="block_edit">
                        <textarea id="comment_note_content_<?php echo $chi_tiet_buoi_hoc->date."_".$stt; ?>" cols="30" ><?php echo isset($chi_tiet_buoi_hoc->note_comment)?$chi_tiet_buoi_hoc->note_comment:'';?></textarea>
                        <button class="save_comment_note" stt="<?php echo $stt; ?>" date="<?php echo $chi_tiet_buoi_hoc->date;?>" id_nkgd="<?php echo $id_nkgd; ?>" id_subject="<?php echo $chi_tiet_buoi_hoc->id_subject?>" id_teacher="<?php echo $chi_tiet_buoi_hoc->id_prof ?>">Edit</button>
                      </div>
                      <p style="font-size: 12px;color:red" id="error_comment_note_<?php echo $chi_tiet_buoi_hoc->date."_".$stt; ?>"></p>
                    </td>
                    <td><?php echo $chi_tiet_buoi_hoc->teacher_name;?></td>
                    <td class="hour"><?php
                      echo $chi_tiet_buoi_hoc->hours;
                     ?></td>
                    <td>
                        <span >
                          <?php echo isset($chi_tiet_buoi_hoc->notes)?$chi_tiet_buoi_hoc->notes:'';?>
                        </span>
                        <i class="material-icons notes">mode_edit</i>
                        <div style="display:none" class="block_edit">
                          <textarea id="notes_content_<?php echo $chi_tiet_buoi_hoc->date."_".$stt; ?>" cols="30" ><?php echo isset($chi_tiet_buoi_hoc->notes)?$chi_tiet_buoi_hoc->notes:'';?></textarea>
                          <button class="save_notes" stt="<?php echo $stt; ?>" date="<?php echo $chi_tiet_buoi_hoc->date;?>" id_nkgd="<?php echo $id_nkgd; ?>" id_subject="<?php echo $chi_tiet_buoi_hoc->id_subject?>" id_teacher="<?php echo $chi_tiet_buoi_hoc->id_prof ?>">Edit</button>
                        </div>
                        <p style="font-size: 12px;color:red" id="error_notes_<?php echo $chi_tiet_buoi_hoc->date."_".$stt; ?>"></p>
                    </td>
                  </tr>
            <?php $stt++; } }?>
            <tr>
              <td colspan=7><strong>Total hours of studying</strong></td>
              <td colspan=2 id="total_hours"></td>
            </tr>
            <tr>
              <td colspan=7><strong>Number remaining hours of the current package</strong></td>
              <td colspan=2 id="time_left"></td>
            </tr>
          </tbody>
        </table>
        
    </div>
    <div class="footer">
      
    </div>


    <script>
      var elementHour = document.getElementsByClassName("hour");
      var total = 0;
      for (let index = 0; index < elementHour.length; index++) {
         total += parseFloat(elementHour[index].innerText);
      }
      document.getElementById("total_hours").innerText = total+" Hour";
      //Lấy thời gian thực tế bé học so sánh với thời gian học trong report ( đề phòng trường hợp bé học trước ngày bắt đầu trong hóa đơn - Chỉ áp dụng cho report gói giờ)
      <?php if($month=='') {?>
      var time_left = <?php echo $amount_of_hours_last_package ?>-total;

      if(time_left!=<?php echo is_array($time_left)?end($time_left):$time_left ?>){
        document.getElementById("error_display").innerText="Kiểm tra lại dữ liệu vì 'Ngày bắt đầu không trùng với ngày bắt đầu thực tế (bé đăng ký học sớm hơn dự kiến)! - bạn cần vào phần Renew history trong nhật ký giảng dạy để sửa lại ngày bắt đầu'";
      }
      document.getElementById("time_left").innerText = <?php echo $amount_of_hours_last_package ?>-total+ " Hour";
      <?php } ?>
      //end
      
      // Hàm quản lý sự kiện các nút input
  
      document.querySelector('[type=month]').addEventListener("change",function(){
        var month = document.querySelector('[type=month]').value;
        
        document.location.href = "?id_nkgd=<?php echo $id_nkgd; ?>&month="+month;
      })
      document.querySelector('#current_package_report').addEventListener("click",function(){
        document.location.href= "?id_nkgd=<?php echo $id_nkgd; ?>";
      })
      //Bắt sự kiện user click chỉnh sửa note
      var arrayButtonEditNote = document.querySelectorAll('.button_note_edit');
      for (let i = 0; i < arrayButtonEditNote.length; i++) {
        arrayButtonEditNote[i].addEventListener("click",function(){
          var temp = document.getElementById('note_block_'+(i+1)).style.display;
          if(temp == "none"){
            document.getElementById('note_block_'+(i+1)).style.display = "block";
          }else{
            document.getElementById('note_block_'+(i+1)).style.display= "none";
          }
        });
        
      }
      // Hàm sửa Teacher note 
      var obj_teacher_note = document.getElementsByClassName("note_giao_vien");
      for (let i = 0; i < obj_teacher_note.length; i++) {
        obj_teacher_note[i].addEventListener("keyup",function(event){
            if(event.keyCode ===13){
             document.getElementById('save_button_note_'+(i+1)).click();
             document.getElementById('error_'+(i+1)).innerText = 'Saved';
            }
        });
      }
     
      // Thêm note giáo viên
      function ajax_note_gv(id,mytime,mytag,ma_mon,ma_giao_vien) {
        var note = document.getElementById(mytag).value;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            // alert('Upload note success!');
          }
        }
        xhttp.open("GET", "send-note.php?id=" + id + "&mytime=" + mytime +
          "&note=" + note + "&subject=" + ma_mon + "&ma_giao_vien=" + ma_giao_vien+ "&note_gv=1", true);
        xhttp.send();
      }
    </script>
    <script
    src="https://code.jquery.com/jquery-3.6.0.js"
    integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>

    <script>
      $('.save_comment_note').click(function (e) { 
        let date = $(this).attr("date");
        let stt = $(this).attr("stt");
        let value_note = $('#comment_note_content_'+date+'_'+stt).val();
        let object_param={
            id:$(this).attr("id_nkgd"),
            mytime: date,
            note:value_note,
            subject:$(this).attr("id_subject"),
            ma_giao_vien:$(this).attr("id_teacher"),
            type_note:'note_comment'
        }
        $(this).parent().prev().prev().text(value_note);
        $(this).parent().hide(500);
        $.ajax({
          type: "GET",
          url: "./send-note.php",
          data: object_param,
          success: function (response) {
            $('#error_comment_note_'+date+'_'+stt).text('Saved!');
          }
        });
      });
      $('.save_notes').click(function (e) { 
        let date = $(this).attr("date");
        let stt = $(this).attr("stt");
        let value_note = $('#notes_content_'+date+'_'+stt).val();
        let object_param={
            id:$(this).attr("id_nkgd"),
            mytime: date,
            note:value_note,
            subject:$(this).attr("id_subject"),
            ma_giao_vien:$(this).attr("id_teacher"),
            type_note:'notes'
        }
        $(this).parent().hide(500);
        $(this).parent().prev().prev().text(value_note);
        $.ajax({
          type: "GET",
          url: "./send-note.php",
          data: object_param,
          success: function (response) {
            $('#error_notes_'+date+'_'+stt).text('Saved!');
          }
        });
      });
      $('.save_lesson_note').click(function (e) { 
        let date = $(this).attr("date");
        let stt = $(this).attr("stt");
        let value_note = $('#lesson_note_content_'+date+'_'+stt).val();

        let object_param={
            id:$(this).attr("id_nkgd"),
            mytime: date,
            note:value_note,
            subject:$(this).attr("id_subject"),
            ma_giao_vien:$(this).attr("id_teacher"),
            type_note:'lesson_note'
        }
        $(this).parent().hide(500);
        $(this).parent().prev().prev().text(value_note);
        $.ajax({
          type: "GET",
          url: "./send-note.php",
          data: object_param,
          success: function (response) {
            $('#error_lesson_note_'+date+'_'+stt).text('Saved!');
          }
        });
      });
      $('.comment_note').click(function(e){
        $(this).next().toggle(500);
      });
      $('.lesson_note').click(function(e){
        $(this).next().toggle(500);
      });
      $('.notes').click(function(e){
        $(this).next().toggle(500);
      });
    </script>
    
  </div>
</body>
</html>