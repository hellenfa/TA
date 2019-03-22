
    <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" aria-label="Close" data-dismiss-modal="#VehModal">
                	<span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="myModalLabel">Hapus Lampiran</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url('logbook/delete_attachment') ?>">
                <input type="hidden" name="a" value="a">
                <div class="modal-body text-center">
                    <span class="fa fa-exclamation-triangle fa-5x" style="color: orange"></span>
                    <h3>Anda yakin mau menghapus ?</h3>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
            </div>
            </div>
<script>

