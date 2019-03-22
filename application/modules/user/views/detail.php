<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">
                <center>DETAIL AKSES FOLDER</center>
            </h4>
        </div>
        <div style="display: block; height: 300px; width:auto; overflow: scroll">
        <form class="form-horizontal" action="<?php echo base_url('user/detail') ?>" method="post" role="form">
            <div class="modal-body">
                        <table class="table">
                        <?php foreach ($userakses as $data): ?>
                        <?php echo '<tr> <td><i class="fa fa-circle-o" style="color:yellow"></i>&nbsp&nbsp' . $data->folder_name . '</td></tr>';  ?>
                        <?php endforeach; ?>
                    </table>
            </div>
        </div>
        </form>   
        </div>
    </div>
</div>
