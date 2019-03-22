  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title">Edit</h4>
      </div>
      <form class="form-horizontal" action="<?php echo base_url(); ?>progress_report/edit_sumber_dana/<?php echo $sumberdana->id_dana ?>" method="post" enctype="multipart/form-data" role="form">
      <div class="modal-body" id="modal-edit">
          <div class="form-group">
           <label class="col-lg-3 control-label">Nama Sumber Dana:</label>
            <div class="col-lg-8">
              <input class="form-control" type="hidden" name="id_dana" id="id_dana" value="<?php echo $sumberdana->id_dana; ?>">
              <input class="form-control" type="text" name="dana_name" id="dana_name" value="<?php echo $sumberdana->dana_name; ?>">
            </div>
          </div>
          <br>
      </div>
      <div class="modal-footer">
        <button class="btn btn-info" type="submit"> Save</button>
      </div>
      </form>
      <?php echo px_validate("
        'sumber_dana_name': {
            maxlength: 190,
         },
          "); ?>
    </div>
  </div>