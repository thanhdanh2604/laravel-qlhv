<!-- Button trigger modal -->
{{-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit_time_date">
  Edit time
</button> --}}

<!-- Modal -->
<div class="modal fade" id="edit_time_date" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change date</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <input type="text" name="edit_time_id_nkgd" >
                <input type="text" name="edit_time" >
                <input type="text" name="edit_time_id_teacher">
                <input type="text" name="edit_time_id_subject">
                <label for="edit_time_start">Start Time</label>
                <input class="form-control" type="time" value="" id="edit_time_start" placeholder="Start At">
                <label for="edit_time_end">End Time</label>
                <input class="form-control" type="time" value="" id="edit_time_end" placeholder="End At">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn_save-time">Save</button>
            </div>
        </div>
    </div>
</div>
