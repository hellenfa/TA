  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title">Edit</h4>
      </div>
      <form class="form-horizontal" action="<?php echo base_url(); ?>progress_report/edit_tahap_lelang/<?php echo $tahaplelang->id_tahap_lelang ?>" method="post" enctype="multipart/form-data" role="form">
      <div class="modal-body" id="modal-edit">
          <div class="form-group">
           <label class="col-lg-3 control-label">Auction Step Name:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" name="tahap_lelang_name" id="tahaps_lelang_name" value="<?php echo $tahaplelang->tahap_lelang_name; ?>">
            </div>
          </div>
          <br>
      </div>
      <div class="modal-footer">
        <button class="btn btn-info" type="submit"> Save</button>
      </div>
      </form>
      <?php echo px_validate("
        'tahap_lelang_name': {
            maxlength: 190,
         },
          "); ?>
    </div>
  </div>