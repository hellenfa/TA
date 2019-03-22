<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <br>
            <div class="row">
                <div class="col-md-2 col-md-offset-5">
                    <img class="profile-user-img img-responsive img-circle"
                         src="<?php echo base_url('profile_picture/') . $this->ion_auth->user()->row()->profile_picture; ?>"
                         onerror="this.src='<?php echo base_url(); ?>assets/images/user.jpg'"
                         alt="User profile picture">
                    <br>
                    <form action="<?php echo base_url('auth/change_image'); ?>" method="post"
                          enctype="multipart/form-data">
                        <input type="file" name="files" required>
                        <br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><span class="fa fa-upload"></span>&nbsp;
                                Unggah dan Simpan
                            </button>
                        </div>
                    </form>
                    <h3 class="profile-username text-center"><?php echo $this->ion_auth->user($id)->row()->first_name . ' ' . $this->ion_auth->user($id)->row()->last_name ?></h3>
                </div>
            </div>
            <div class="panel-body">
                <?php echo form_open(uri_string(), array('id' => 'validation-form')) ?>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo bs_input('Nama Lengkap', "disabled", $this->ion_auth->user($id)->row()->first_name . ' ' . $this->ion_auth->user($id)->row()->last_name) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo bs_input('Email', "required", $this->ion_auth->user($id)->row()->email, 'email') ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo bs_input('Username', "required", $this->ion_auth->user($id)->row()->username, 'text') ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <?php echo bs_input('Nomor Telepon', 'required', $this->ion_auth->user($id)->row()->phone, 'text') ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo bs_input('Password (Isi jika ingin diubah)',"", null, 'password', 'password', 'password') ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo bs_input('Konfirmasi Password', "", null, 'password', 'konfirmasi_password') ?>
                    </div>
                </div>
                <?php echo form_hidden('id', $users->id); ?>
                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<?php echo px_validate("
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
                    remote: '" . base_url('auth/api_username') . "?old_username=" . $this->ion_auth->user()->row()->username . "'
                },
                password: {},
                konfirmasi_password: {
                    equalTo: '#password'
                }"); ?>
