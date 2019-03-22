  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title">Add Detail Subactivity</h4>
      </div>
      <form class="form-horizontal" action="<?php echo base_url('progress_report/create_detail_subkegiatan_manually').'/'.$id ?>" method="post" enctype="multipart/form-data" role="form" id="validation-form">
         <div class="modal-body">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <?php echo bs_input("Detail Subactivity Name"); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="form-group">
                        <label>Plan Start</label>
                        <input class="form-control" name="plan_start" id="plan_start" type="text">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="form-group">
                        <label>Plan Finish</label>
                        <input class="form-control" name="plan_finish" id="plan_finish" type="text">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <?php echo bs_input("Staff"); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <?php echo bs_input("Verificator"); ?>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-info" type="submit">ADD</button>
          </div>
      </form>
      <?php echo DatePicker() ?>
      <?php echo px_validate("
        'detail_subactivity_name': {
            maxlength: 190,
         },
          "); ?>
    </div>
  </div>
  
<script type="text/javascript">
    $(function () {
        $('#plan_start').datepicker();
        $('#plan_finish').datepicker();

        $("#plan_start").on('changeDate', function(ev){
        $("#plan_start").datepicker('hide');
        });
        $("#plan_finish").on('changeDate', function(ev){
        $("#plan_finish").datepicker('hide');
        });
        // $("#datetimepicker6").on("dp.change", function (e) {
        //     $('#datetimepicker7').data("DatePicker").minDate(e.date);
        // });
        // $("#datetimepicker7").on("changeDate", function (e) {
        //     $('#datetimepicker6').data("DatePicker").maxDate(e.date);
        // });

        $( "#plan_start" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 3,
        onClose: function( selectedDate ) {
          $( "#plan_finish" ).datepicker( "option", "minDate", selectedDate );
        }
        });
        $( "#plan_finish" ).datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 3,
          onClose: function( selectedDate ) {
            $( "#plan_start" ).datepicker( "option", "maxDate", selectedDate );
          }
        });
    });
</script>