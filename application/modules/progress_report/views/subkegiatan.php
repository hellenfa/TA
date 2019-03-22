<h4 class="m-y-1 font-weight-normal"><a href="<?php echo base_url('progress_report/index'); ?>"><i class="fa fa-home"></i></a>&nbsp;/ <?php echo $bc_sumber_dana; ?>&nbsp;/ <?php echo $bc_kegiatan; ?>&nbsp;/ <?php echo $bc_subkegiatan; ?></h4>
<br>
<div class="row">
    <div class="col-md-12">
    <?php if($this->ion_auth->user()->row()->type=='admin'){?>
        <a href="<?php echo base_url('progress_report/create_detail_subkegiatan_manually') . '/' . $id; ?>" id="btnAdd" target="ajax-modal" class="btn btn-info btn-lg"><span class="fa fa-plus"></span>&nbsp; ADD DETAIL SUBACTIVITY</a><br><br>
    <?php } ?>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Detail Subactivity</h1>
    </div>
    <div class="panel-body">
        <table id="jq-datatables-example" class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Detail Subactivity Name</th>
                <th>Plan Start</th>
                <th>Plan Finish</th>
                <th>Actual Start</th>
                <th>Actual Finish</th>
                <th>Document</th>
                <th> </th>
                <?php if($this->ion_auth->user()->row()->type=='admin'){?>
                <th>Verification</th>
                <?php } ?>
                <th>Status</th>
                <th>Notes</th>
                <?php if($this->ion_auth->user()->row()->type=='admin'){?>
                <th>Action</th>
                <?php } ?>
            </tr>
            </thead>
        </table>
    </div>
</div>
<?php echo datatable("progress_report", 'progress_report/fetch_data_detail_subkegiatan/'.$id,'jq-datatables-example',true,array(1,'desc')); ?>
