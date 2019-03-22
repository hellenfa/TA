<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">TAMBAH DOKUMEN</h4>
        </div>
        <form class="form-horizontal" action="<?php echo base_url('progress_report/do_upload').'/'.$id ?>" method="post"
              enctype="multipart/form-data" role="form">
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-lg-4 col-sm-4 control-label">File :</label>
                    <div class="col-lg-6">
                        <input type="file" class="form-control" name="files" accept="application/pdf">
                        *pdf
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-info" type="submit" value="upload" id="btnUpload" onclick="btnUploadClick()" required="yes">TAMBAH</button>
                </div>
        </form>
    <?php echo px_validate(); ?>
</div>
</div>
<script type="text/javascript">
    function btnUploadClick(){
    $("#btnUpload").text("MENGUNGGAH");
    $("#btnUpload").css("background-color","grey");
    // $("#btnUpload").attr("disabled", true);
    }
</script>