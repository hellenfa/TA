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
          <br>
          <div class="form-group">
           <label class="col-lg-3 control-label">Access Preview:</label>
            <div class="col-lg-8">
              <div class="m-b-2">
              <select id="select-access" name="akses[]" class="form-control select2-example" multiple="" style="width: 100%">
                <?php foreach ($users as $data): ?>
                  <option <?php echo $this->dokumentasi_model->access($dokumentasis->id_folder,$data->id) ? "selected" : "" ?> value="<?php echo $data->id; ?>"><?php echo $data->first_name.' '.$data->last_name; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            </div>
          </div>
          <div class="form-group">
           <label class="col-lg-3 control-label">Access Download:</label>
            <div class="col-lg-8">
              <div class="m-b-2">
              <select id="select-access-download" name="akses_download[]" class="form-control select2-example" multiple="" style="width: 100%" tabindex="-1" aria-hidden="true">
                  <option disabled value="">Data tidak ditemukan</option>
              </select>
            </div>
            </div>
          </div> 
      </div>
      <div class="modal-footer">
        <button class="btn btn-info" type="submit"> Save</button>
      </div>
      </form>
    </div>
  </div>

<script type="text/javascript">
<?php
  $ci =& get_instance();
  if ($ci->input->is_ajax_request()) { ?>
        $(function() {
        <?php } else {?>
        pxInit.push(function() {
        <?php } ?>
            $('.select2-example').select2({
                placeholder: 'Select user',
                <?php if ($ci->input->is_ajax_request()) { ?>dropdownParent: $('#myModelDialog')<?php } ?>
            });
    var select_access = $('#select-access');
    var multiVal = select_access.val();
    var _url = '<?php echo base_url('/'); ?>dokumentasi/api_user';
    var result = '';
    var select_access_download = $('#select-access-download');

    $.get(_url, function (data) {
        $.each(data, function (key, items) {
            _text = items.name;
            _val = items.id;

            if ($.inArray(_val, multiVal) !== -1) {
                result += "<option value='" + _val + "'>" + _text + "</option>";
            }

        });

        select_access_download.html(result);
    });
    
    select_access.on('change', function () {
        updateSelectAccessDownload($(this).val());
    });

    function updateSelectAccessDownload(opt){
        result = '';
        $.get(_url, function (data) {
            $.each(data, function (key, items) {
                _text = items.name;
                _val = items.id;

                if ($.inArray(_val, opt) !== -1 ) {
                    result += "<option value='" + _val + "'>" + _text + "</option>";
                }
            });

            select_access_download.html(result);
        });
    }
});
</script>