  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title">Catatan</h4>
      </div>
      <form class="form-horizontal" action="<?php echo base_url(); ?>progress_report/view_notes/<?php echo $view_notes->id_detail_subkegiatan ?>" method="post" enctype="multipart/form-data" role="form">
      <div class="modal-body" id="modal-edit">
        <div class="row">
          <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
              <textarea rows="5" cols="40" class="form-control" id="notes" readonly="yes" name="notes"><?=set_value('notes', $view_notes->notes)?></textarea>
            </div>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>