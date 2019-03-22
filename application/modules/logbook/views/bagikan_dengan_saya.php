
<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Bagikan dengan Saya</h1>
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
<?php echo datatable("Logbook",'logbook/fetch_data_bagikan_dengan_saya'); ?>