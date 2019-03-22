<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="myModalLabel">Tidak Aktif Pengguna</h3>
        </div>
        <form class="form-horizontal" method="post" action="<?php echo base_url('dokumentasi/non_active')?>">
        <div class="modal-body">
            <p>Anda yakin menonaktifkan pengguna ini ?</p>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-info">OK</button>
        </div>
        </form>
    </div>
</div>
