<h4 class="m-y-1 font-weight-normal"><a href="<?php echo base_url('progress_report/index'); ?>"><i class="fa fa-home"></i></a>&nbsp;/ <?php echo $bc_sumber_dana; ?>&nbsp;/ <?php echo $bc_kegiatan; ?></h4>
<br>
<div class="row">
    <div class="col-md-12">
    <?php if($this->ion_auth->user()->row()->type=='admin'){?>
        <a href="<?php echo base_url('progress_report/create_subkegiatan') . '/' . $id; ?>" id="btnAdd" target="ajax-modal" class="btn btn-info btn-lg"><span class="fa fa-plus"></span>&nbsp; ADD SUBACTIVITY</a>
        <br><br>
    <?php } ?>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Subactivity</h1>
    </div>
    <div class="panel-body">
        <table id="jq-datatables-example" class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Subactivity Name</th>
                <th>Date Created</th>
                <!-- <th>Status</th> -->
                <?php if($this->ion_auth->user()->row()->type=='admin'){?>
                <th>Action</th>
                <?php } ?>
            </tr>
            </thead>
        </table>
    </div>
</div>
<?php echo datatable("progress_report", 'progress_report/fetch_data_subkegiatan/'.$id); ?>
