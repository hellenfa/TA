<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myAddModalLabel">Tambah Pengguna</h4>
        </div>
		<?php echo form_open( 'auth/create_user', array( 'id' => 'tambah_pengguna' ) ) ?>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
					<?php echo bs_input( 'Nama Lengkap' ) ?>
                </div>
                <div class="col-md-6">
					<?php echo bs_input( 'Nama Publikasi' ) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
					<?php echo bs_input( 'Email', null, 'email' ) ?>
                </div>
                <div class="col-md-6">
					<?php echo bs_input( 'Username', null, 'text', 'username' ) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="">Instansi</label>
                    <select name="instansi" class="form-control">
                        <?php foreach ($instansi as $data): ?>
                        <option value="<?php echo $data->id ?>"><?php echo $data->unit ?></option>
                        <?php  endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
					<?php echo bs_input( 'NIP/NPU', null, 'text','nip' ,'nip') ?>
                </div>
                <div class="col-md-3">
					<?php echo bs_input( 'Nomor Telepon' ) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
					<?php echo bs_input( 'Password', null, 'password', 'password' ) ?>
                </div>
                <div class="col-md-6">
					<?php echo bs_input( 'Konfirmasi Password', null, 'password' ) ?>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
		<?php echo form_close() ?>
    </div>
</div>

<script>
    $("#tambah_pengguna").pxValidate({
        ignore: '.ignore, .select2-input',
        focusInvalid: false,
        rules: {
            nama_lengkap: {
                maxlength: 100,
                required: true
            },
            nama_publikasi: {
                maxlength: 100,
                required: true
            },
            email: {
                maxlength: 100,
                required: true,
                email: true
            },
            nomor_telepon: {
                maxlength: 15,
                required: true
            },
            username: {
                maxlength: 100,
                required: true,
                remote: '<?php echo base_url( 'auth/api_username' ) ?>'
            },
            password: {
                required: true
            },
            konfirmasi_password: {
                equalTo: "#password"
            }

        }
    });
</script>