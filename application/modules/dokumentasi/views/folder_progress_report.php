<h4 class="m-y-1 font-weight-normal"><a href="<?php echo base_url('dokumentasi/index'); ?>"><i class="fa fa-home"></i></a>&nbsp;&nbsp;/ <?php echo $bc; ?></h4>
<br>
<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Documentation</h1>
    </div>
    <div class="panel-body">
        <table id="jq-datatables-example" class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Name</th>
                <th>Date Created</th>
                <th>Detail</th>
                <?php if($this->ion_auth->user()->row()->type=='admin'){?>
                <th>Action</th>
                <th>Log</th>
                <?php } ?>
            </tr>
            </thead>
        </table>
    </div>
</div>
<?php echo datatable("Dokumentasi", 'dokumentasi/fetch_data_folder_progress_report/'.$id); ?>
