  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title">Revision</h4>
      </div>
      <form class="form-horizontal" action="<?php echo base_url(); ?>progress_report/revisi_detail_subkegiatan/<?php echo $revisi_detail_subkegiatan->id_detail_subkegiatan ?>" method="post" enctype="multipart/form-data" role="form">
      <div class="modal-body" id="modal-edit">
          <div class="row">
            <div class="col-md-10 col-md-offset-1">
              <div class="form-group">
                <label>Detail Subactivity Name:</label>
                <input class="form-control" type="text" readonly="yes" name="detail_subkegiatan_name" id="detail_subkegiatan_name" value="<?php echo $revisi_detail_subkegiatan->detail_subkegiatan_name; ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-10 col-md-offset-1">
              <div class="form-group">
                <label>Notes:</label>
                <textarea rows="5" cols="40" class="form-control" id="notes" required="required" name="notes"></textarea>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-warning" type="submit"> Revision</button>
      </div>
      </form>
      <?php echo px_validate("
        'detail_subkegiatan_name': {
            maxlength: 190,
         },
         'notes': {
            maxlength: 190,
         },
          "); ?>
    </div>
  </div>