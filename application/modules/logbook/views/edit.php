
    <div class="modal-dialog">
    <div class="modal-content">

        <div class="modal-header">
            <button aria-hidden="true" data-dismiss-modal="#addModal" class="close" type="button">×</button>
            <h4 class="modal-title">
                <center>UBAH LOGBOOK</center>
            </h4>
        </div>
        <form class="form-horizontal" action="<?php echo base_url(); ?>logbook/edit/<?php echo $logbook->id_logbook ?>" method="post" 
              role="form" id="validation-form" enctype="multipart/form-data">
            <div class="modal-body">
            <div class="col-md-10 col-md-offset-1">
            <div class="row">
                <div class="col-md-5 col-md-offset-0"><?php echo bs_input("Nama Logbook", "required", $logbook->logbook_name, $logbook->id_logbook, "logbook_name"); ?></div>
                <div class="col-md-6 col-md-offset-1">
                        <label for="">Tanggal Logbook</label>
                        <input id="datepicker" type="text" class="form-control" value="<?php echo date('d-m-Y') ?>">
                </div>
            </div>
            <div class="form-group">
                    <label>Unggah Dokumen</label>
                    <input type="file" class="form-control" name="files[]" multiple="">
                        *pdf, jpeg, jpg
            </div>
            <div class="form-group">
                <table class="table">
                        <?php foreach ($lampiran as $data): ?>
                        <?php echo '<tr> <td width="310px"><a target="_blank" href="logbook/get_attachment/'.$data->id_attach.'">' . $data->attach_name . '</a></td><td><a href="logbook/download_attachment/'.$data->id_attach.'" class="btn btn-success" onclick="download_attachment(<?php echo $data->id_attach;?>);">Unduh</a>&nbsp&nbsp<a href="logbook/delete_attachment/'.$data->id_attach.'" class="btn btn-danger" onclick="return confirm("Yakin ingin menghapus ")" >Hapus</a></td></tr>';  ?>
                        <?php endforeach; ?>
                    </a>
                    </table>
            </div>
            <div class="form-group">
                <label>Deskripsi Logbook</label>
                    <div class="controls">
                        <textarea rows="5" cols="40" class="form-control" id="description" required="required" name="deskripsi"><?=set_value('deskripsi', $logbook->description)?></textarea>
                        <span class="help-block"></span>
                     </div>
            </div>

            </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info" type="submit"> SIMPAN</button>
            </div>

        </form>
        <?php echo datepicker(); ?>
        <?php echo px_validate("
        'nama_logbook': {
            maxlength: 190,
         },
          "); ?>
    </div>
</div>
<!-- <script>
function myFunction() {
  var txt;
  if (confirm("Apakah anda yakin ingin menghapus lampiran ini ?")) {
    window.location.href='logbook/delete_attachment/'.$id;
  } else {
    return false;
  }
  document.getElementById("demo").innerHTML = txt;
}
</script> -->




