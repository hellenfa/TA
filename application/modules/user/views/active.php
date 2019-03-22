<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="myModalLabel">Aktif Pengguna</h3>
        </div>
        <form class="form-horizontal" method="post" action="<?php echo base_url('user/update_status/').$id ?>">
        <input type="hidden" name="a" value="a">
        <div class="modal-body text-center">
            <span class="fa fa-exclamation-triangle fa-5x" style="color: #3CB371"></span>
            <h3>Anda yakin akan mengaktifkan <?php echo $users->first_name.' ' . $users->last_name;?> ?</h3>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-info">OK</button>
        </div>
        </form>
    </div>
</div>
