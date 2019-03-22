<div class="panel panel-default">
    <div class="panel-body">
        <table id="jq-datatables-example" class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Document Name</th>
                <?php if($this->ion_auth->user()->row()->type=='admin'){?> 
                <th>Action</th>
                <?php } ?>
            </tr>
            </thead>
        </table>
    </div>
</div>
<?php echo datatable("Recycle_bin", 'recycle_bin/fetch_data'); ?>