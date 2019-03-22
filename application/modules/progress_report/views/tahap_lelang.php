<div class="row">
    <div class="col-md-12">
        <a href="<?php echo base_url('progress_report/create_tahap_lelang') . '/' . $id; ?>" id="btnAdd" target="ajax-modal"
           class="btn btn-info btn-lg"><span class="fa fa-plus"></span>&nbsp; TAMBAH TAHAP LELANG</a><br><br>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Tahap Lelang</h1>
    </div>
    <div class="panel-body">
        <table id="jq-datatables-example" class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Nama Tahap Lelang</th>
                <th>Aksi</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<?php echo datatable("progress_report", 'progress_report/fetch_data_tahap_lelang/'.$id); ?>