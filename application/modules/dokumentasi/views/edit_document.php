  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title">Edit</h4>
      </div>
      <form class="form-horizontal" action="<?php echo base_url(); ?>dokumentasi/edit_document/<?php echo $dokumentasi->id_doc ?>" method="post" enctype="multipart/form-data" role="form">
      <div class="modal-body" id="modal-edit">
          <div class="form-group">
           <label class="col-lg-3 control-label">Document Name:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" name="doc_name" id="doc_name" value="<?php echo $dokumentasi->doc_name; ?>">
            </div>
          </div>
          <br>
      </div>
      <div class="modal-footer">
        <button class="btn btn-info" type="submit">Save</button>
      </div>
      </form>
    </div>
  </div>