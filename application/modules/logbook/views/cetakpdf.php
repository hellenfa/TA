<div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="myModalLabel">Logbook</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo base_url('logbook/index') ?>">
                <input type="hidden" name="a" value="a">
                <div class="modal-body text-center">
                    
                    <h3>hello world</h3>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="cetak" class="btn btn-danger">Cetak PDF</button>
                </div>
            </form>
            </div>
            </div>