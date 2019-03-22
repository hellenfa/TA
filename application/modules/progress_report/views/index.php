<div class="row">
    <div class="col-md-12">
        <?php if($this->ion_auth->user()->row()->type=='admin'){?>
            <a href="<?php echo base_url('progress_report/create_sumber_dana') ?>" id="btnAdd" target="ajax-modal" class="btn btn-info btn-lg"><span class="fa fa-plus"></span>&nbsp; TAMBAH SUMBER DANA</a>
            <br><br>
        <?php } ?>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Sumber Dana</h1>
    </div>
    <div class="panel-body">
        <table id="jq-datatables-example" class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Nama Sumber Dana</th>
                <?php if($this->ion_auth->user()->row()->type=='admin'){?>
                <th>Aksi</th>
                <?php } ?>
            </tr>
            </thead>
        </table>
    </div>
</div>
<?php echo datatable("progress_report", 'progress_report/fetch_data'); ?>