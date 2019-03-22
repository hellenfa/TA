<div class="panel">
    <div class="panel-heading">
        <h1 class="panel-title">Buat Grup</h1>
    </div>
    <div class="panel-body">
        <?php echo form_open("auth/create_group");?>
        <div class="form-group">
            <label>Nama Grup</label>
            <input type="text" class="form-control" name="nama_grup">
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <input type="text" class="form-control" name="deskripsi">
        </div>
        <button class="btn btn-primary" type="submit">Simpan</button>
        <?php echo form_close();?>
    </div>
</div>