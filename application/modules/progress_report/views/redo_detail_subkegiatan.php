  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title">Redo Detail Subactivity</h4>
      </div>
      <form class="form-horizontal" action="<?php echo base_url(); ?>progress_report/redo2_detail_subkegiatan/" method="post" enctype="multipart/form-data" role="form">
      <div class="modal-body" id="modal-edit">
        <div class="form-group">
            <label class="col-lg-3 control-label">Detail Subactivity Name:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" name="detail_subkegiatan_name" id="detail_subkegiatan_name" value="<?php echo $redo_detail_subkegiatan->detail_subkegiatan_name; ?>">
              <input class="form-control" type="hidden" name="id_jenis_lelang" id="id_jenis_lelang" value="<?php echo $redo_detail_subkegiatan->id_jenis_lelang; ?>">
              <input class="form-control" type="hidden" name="id_subkegiatan" id="id_subkegiatan" value="<?php echo $redo_detail_subkegiatan->id_subkegiatan; ?>">
            </div>
          </div>
          <div class="form-group">
           <label class="col-lg-3 control-label">Plan Start:</label>
            <div class="col-lg-8">
              <input class="start-date" type="date" name="plan_start" id="date-pick" required="yes">
            </div>
          </div>
          <div class="form-group">
           <label class="col-lg-3 control-label">Plan Finish:</label>
            <div class="col-lg-8">
              <input class="end-date" type="date" name="plan_finish" id="date-pick" required="yes">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-info" type="submit" name="submit" value="submit"> Redo</button>
      </div>
      </form>
      <?php echo px_validate("
        'detail_subkegiatan_name': {
            maxlength: 190,
         },
          "); ?>
    </div>
  </div>