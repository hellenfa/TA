<div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="myModalLabel">Unduh Logbook</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url('logbook/index')?>">
                <div class="modal-body">
                    <p>Anda yakin akan menyimpan ?</p>
                    <div class="row">
                <div class="col-md-2"><i class="fa fa-file-pdf-o" style="font-size:80px;color:red"></i></div>
                <div class="col-md-2">
                    <p>Nama :</p>
                    <p>Tipe :</p>
                    <p>Dari :</p>
                </div>  
            </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Simpan</button>
                    <button type="submit" class="btn btn-danger">Batal</button>
                </div>
            </form>
            </div>
            </div>
