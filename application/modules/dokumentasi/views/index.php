<div class="row">
    <div class="col-md-12">
        <?php if($this->ion_auth->user()->row()->type=='admin'){?>
            <a href="<?php echo base_url('dokumentasi/create') ?>" id="btnAdd" target="ajax-modal" class="btn btn-info btn-lg"><span class="fa fa-plus"></span>&nbsp; ADD FOLDER</a>
            <br><br>
        <?php } ?>
    </div>
</div>
<div class="panel panel-warning">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-info-circle"></i>&nbsp;Info
          <div class="pull-right"> <a href="#" data-perform="panel-dismiss" class="btn btn-warning btn-xs pull-right"><i class="fa fa-times"></i></a> <a href="#" data-perform="panel-collapse" class="btn btn-warning btn-xs pull-right"><i class="fa fa-minus"></i></a> </div>
        </h4>
    </div>
    <div class="panel-wrapper collapse in">
            <div class="panel-body">
            1. Click <button type="button" class="btn btn-info btn-xs"><i class="fa fa-plus"></i>&nbsp;ADD FOLDER</button> to add folder. </br></br>
            2. Click <button type="button" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i>&nbsp;Edit</button> to edit folder. You can edit folder name, access preview (users can only see documents inside the folder), and access download (users can see and download documents inside the folder)</br></br>
            3. Click <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>&nbsp;Delete</button> to delete folder.</br></br>
            4. To see subfolders or documents inside a folder, click on the folder name.
            </div>
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
                <th>Folder Name</th>
                <th>Date Created</th>
                <?php if($this->ion_auth->user()->row()->type=='admin'){?>
                <th class="no-sort">Action</th>
                <?php } ?>
            </tr>
            </thead>
        </table>
    </div>
</div>
<?php echo datatable("Dokumentasi", 'dokumentasi/fetch_data'); ?>
