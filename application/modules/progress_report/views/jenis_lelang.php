<div class="row">
    <div class="col-md-12">
        <a href="<?php echo base_url('progress_report/create_jenis_lelang') ?>" id="btnAdd" target="ajax-modal" class="btn btn-info btn-lg"><span class="fa fa-plus"></span>&nbsp; ADD AUCTION TYPE</a>
        <br><br>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Auction Type</h1>
    </div>
    <div class="panel-body">
        <table id="jq-datatables-example" class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Auction Type Name</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<?php echo datatable("progress_report", 'progress_report/fetch_data_jenis_lelang'); ?>