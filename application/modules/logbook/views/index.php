<a href="<?php echo site_url('logbook/create') ?>" target="ajax-modal" class="btn btn-primary btn-lg"><span class="fa fa-plus"></span>&nbsp; TAMBAH LOGBOOK</a>&nbsp;&nbsp;
<br>
<br>
<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Logbook</h1>
    </div>
   <div class="panel-body">
       <table id="jq-datatables-example" class="table table-striped table-hover">
           <thead>
           <tr>
               <th>Nama Logbook</th>
               <th></th>
               <th>Ukuran</th>
               <th>Terakhir Diubah</th>
               <th class="no-sort">Opsi</th>
           </tr>
           </thead>
           <tbody>

           </tbody>
       </table>
   </div>
</div>
<?php echo datatable("Logbook",'logbook/fetch_data'); ?>