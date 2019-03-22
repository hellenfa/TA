  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title">Edit</h4>
      </div>
      <form class="form-horizontal" action="<?php echo base_url(); ?>progress_report/edit_jenis_lelang/<?php echo $jenislelang->id_jenis_lelang ?>" method="post" enctype="multipart/form-data" role="form">
      <div class="modal-body" id="modal-edit">
          <div class="form-group">
           <label class="col-lg-3 control-label">Auction Type Name:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" name="jenis_lelang_name" id="jenis_lelang_name" value="<?php echo $jenislelang->jenis_lelang_name; ?>">
            </div>
          </div>
          <br>
      </div>
      <div class="modal-footer">
        <button class="btn btn-info" type="submit"> Save</button>
      </div>
      </form>
      <?php echo px_validate("
        'jenis_lelang_name': {
            maxlength: 190,
         },
          "); ?>
    </div>
  </div>