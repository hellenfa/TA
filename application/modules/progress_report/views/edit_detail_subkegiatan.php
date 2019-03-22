  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title">Edit</h4>
      </div>
      <form class="form-horizontal" action="<?php echo base_url(); ?>progress_report/edit_detail_subkegiatan/<?php echo $detailsubkegiatan->id_detail_subkegiatan ?>" method="post" enctype="multipart/form-data" role="form">
      <div class="modal-body" id="modal-edit">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                  <div class="form-group">
                    <label>Detail Subactivity Name:</label>
                    <input class="form-control" type="text" readonly="yes" name="detail_subkegiatan_name" id="detail_subkegiatan_name" value="<?php echo $detailsubkegiatan->detail_subkegiatan_name; ?>">
                  </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="form-group">
                        <label>Plan Start</label>
                        <input class="form-control" name="plan_start" id="date-pick" type="date" value="<?php echo $detailsubkegiatan->plan_start; ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="form-group">
                        <label>Plan Finish</label>
                        <input class="form-control" name="plan_finish" id="date-pick" type="date" value="<?php echo $detailsubkegiatan->plan_finish; ?>">
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-info" type="submit">Save</button>
      </div>
      </form>
      <?php echo px_validate("
        'detail_subkegiatan_name': {
            maxlength: 190,
         },
          "); ?>
    </div>
  </div>
  
  <script type="text/javascript">
    pxInit.push(function () {
      $('.date-pick').datePicker()
      $('#start-date').bind(
      'dpClosed',
      function(e, selectedDates)
        {
          var d = selectedDates[0];
          if (d) {
            d = new Date(d);
            $('#end-date').dpSetStartDate(d.addDays(1).asString());
          }
        }
      );
      $('#end-date').bind(
      'dpClosed',
      function(e, selectedDates)
        {
        var d = selectedDates[0];
        if (d) {
            d = new Date(d);
            $('#start-date').dpSetEndDate(d.addDays(-1).asString());
        }
      }
      );
    });
  </script>