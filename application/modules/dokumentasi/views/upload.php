<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">ADD FILE</h4>
        </div>
        <form class="form-horizontal" action="<?php echo base_url('dokumentasi/do_upload') . '/' . $id ?>" method="post"
              enctype="multipart/form-data" role="form" id="validation-form">
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-lg-4 col-sm-4 control-label">File :</label>
                    <div class="col-lg-6">
                        <input type="file" class="form-control" name="files[]" multiple="" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-info" type="submit" value="upload" id="btnUpload12"> TAMBAH</button>
                </div>
        </form>
        <?php echo px_validate(); ?>
    </div>
</div>