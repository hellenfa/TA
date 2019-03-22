<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">
                <center>ADD ACTIVITY</center>
            </h4>
        </div>
        <form class="form-horizontal" action="<?php echo base_url('progress_report/create_kegiatan').'/'.$id ?>" method="post"
              enctype="multipart/form-data" role="form" id="validation-form">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <?php echo bs_input("Activity Name"); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info" type="submit"> ADD</button>
            </div>
        </form>
        <?php echo px_validate("
        'activity_name': {
            maxlength: 190,
         },
          "); ?>
    </div>
</div>

