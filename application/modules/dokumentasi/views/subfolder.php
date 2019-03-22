<h4 class="m-y-1 font-weight-normal"><a href="<?php echo base_url('dokumentasi/index'); ?>"><i class="fa fa-home"></i></a>&nbsp;&nbsp;/ <?php echo $bc; ?></h4>
<br>
<div class="row">
    <div class="col-md-12">
    <?php if($this->ion_auth->user()->row()->type=='admin'){?>
        <a href="<?php echo base_url('dokumentasi/upload') . '/' . $id; ?>" id="btnUpload" target="ajax-modal"
           class="btn btn-primary btn-lg"><span class="fa fa-plus"></span>&nbsp; ADD DOCUMENT</a>&nbsp;&nbsp;
        <a href="<?php echo base_url('dokumentasi/create_subfolder') . '/' . $id; ?>" id="btnAdd" target="ajax-modal" class="btn btn-info btn-lg"><span class="fa fa-plus"></span>&nbsp; ADD FOLDER</a>
        <br><br>
    <?php } ?>
    </div>
</div>
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
                <?php if($this->ion_auth->user()->row()->type=='admin'){?>
                <th>Action</th>
                <th>Log</th>
                <?php } ?>
            </tr>
            </thead>
        </table>
    </div>
</div>
<?php echo datatable("Dokumentasi", 'dokumentasi/fetch_data_subfolder/'.$id); ?>
