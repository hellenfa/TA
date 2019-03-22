<div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title" id="myModalLabel">Bagikan Logbook</h3>
        </div>
        <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>logbook/share/<?php echo $logbooks->id_logbook ?>" enctype="multipart/form-data" role="form">
        <div class="modal-body">
            <div class="form-group">
                <div class="row">
                <div class="col-md-2 col-md-offset-1"><i class="fa fa-file-text-o" style="font-size:50px;"></i></div>
                <div class="col-md-6">
                    <label><?php echo $logbooks->logbook_name; ?></label></br>
                    <p><?php echo date('d-m-Y h:i a',strtotime($logbooks->updated_date)); ?></p>
                </div>  
            </div>
            </div>
            <div class="form-group">
           <label class="col-lg-3 control-label">Akses:</label>
            <div class="col-lg-8">
              <div class="m-b-2">
              <select name="bagikan[]" class="form-control select2-example select2-hidden-accessible" multiple="" style="width: 100%" tabindex="-1" aria-hidden="true">
                <?php foreach ($users as $data): ?>
                  <option <?php echo $this->logbook_model->access_logbook($logbooks->id_logbook,$data->id) ? "selected" : "";  ?> value="<?php echo $data->id; ?>"><?php echo $data->first_name.' '.$data->last_name; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            </div>
          </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-danger" data-dismiss="modal">Batal</a>
                    <button type="submit" class="btn btn-success">Kirim</button>
                </div>
            </form>
            </div>
            </div>
<script type="text/javascript">
$(function() {
      $('.select2-example').select2({
        placeholder: 'Select user',
        dropdownParent: $('#myModelDialog')
      });
    });
</script>

