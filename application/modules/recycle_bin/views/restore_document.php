  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title">Restore Document</h4>
      </div>
      <form class="form-horizontal" action="<?php echo base_url(); ?>recycle_bin/restore/<?php echo $restore_document->id_doc ?>" method="post" enctype="multipart/form-data" role="form">
      <div class="modal-body" id="modal-edit">
          <div class="form-group">
           Are you sure you want to restore <?php echo $restore_document->doc_name ?>?
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-info" type="submit" name="submit" value="submit">Restore</button>
      </div>
      </form>
    </div>
  </div>