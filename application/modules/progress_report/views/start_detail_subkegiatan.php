  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title">Start Detail Subactivity</h4>
      </div>
      <form class="form-horizontal" action="<?php echo base_url(); ?>progress_report/start_detail_subkegiatan/<?php echo $start_detail_subkegiatan->id_detail_subkegiatan ?>" method="post" enctype="multipart/form-data" role="form">
      <div class="modal-body" id="modal-edit">
          <div class="form-group">
           &nbsp; &nbsp; Are you sure to start <?php echo $start_detail_subkegiatan->detail_subkegiatan_name ?>?
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-info" type="submit" name="submit" value="submit"> Start</button>
      </div>
      </form>
    </div>
  </div>