  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title">Edit</h4>
      </div>
      <form class="form-horizontal" action="<?php echo base_url(); ?>dokumentasi/edit/<?php echo $dokumentasis->id_folder ?>" method="post" enctype="multipart/form-data" role="form">
      <div class="modal-body" id="modal-edit">
          <div class="form-group">
           <label class="col-lg-3 control-label">Folder Name:</label>
            <div class="col-lg-8">
              <input class="form-control" type="hidden" name="id_folder" id="id_folder" value="<?php echo $dokumentasis->id_folder; ?>">
              <input class="form-control" type="text" name="folder_name" id="folder_name" value="<?php echo $dokumentasis->folder_name; ?>">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-info" type="submit"> Save</button>
      </div>
      </form>
    </div>
  </div>