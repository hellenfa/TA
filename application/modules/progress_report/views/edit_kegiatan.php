  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title">Edit</h4>
      </div>
      <form class="form-horizontal" action="<?php echo base_url(); ?>progress_report/edit_kegiatan/<?php echo $kegiatans->id_kegiatan ?>" method="post" enctype="multipart/form-data" role="form">
      <div class="modal-body" id="modal-edit">
          <div class="form-group">
           <label class="col-lg-3 control-label">Activity Name:</label>
            <div class="col-lg-8">
              <input class="form-control" type="hidden" name="id_kegiatan" id="id_kegiatan" value="<?php echo $kegiatans->id_kegiatan; ?>">
              <input class="form-control" type="text" name="kegiatan_name" id="kegiatan_name" value="<?php echo $kegiatans->kegiatan_name; ?>">
            </div>
          </div>
          <br>
      </div>
      <div class="modal-footer">
        <button class="btn btn-info" type="submit"> Save</button>
      </div>
      </form>
      <?php echo px_validate("
        'kegiatan_name': {
            maxlength: 190,
         },
          "); ?>
    </div>
  </div>