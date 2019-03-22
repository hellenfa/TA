<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">
                <center>TAMBAH PENGGUNA</center>
            </h4>
        </div>
        <form class="form-horizontal" action="<?php echo base_url('user/create') ?>" method="post"
              role="form" id="validation-form">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label>Tipe</label>
                            <select name="tipe" class="form-control">
                                <?php
                                $user = array("admin", "pegawai", "pegawai fakultas");
                                foreach ($user as $data) {
                                    ?>
                                    <option value="<?php echo strtolower($data); ?>"><?php echo $data; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <?php echo bs_input("Nama Pengguna", "required", null, "username"); ?>
                        <?php echo bs_input("Nama depan", "required", null, "first_name"); ?>
                        <?php echo bs_input("Nama Belakang", "required", null, "last_name"); ?>
                        <?php echo bs_input("Email", "required", null, "email"); ?>
                        <?php echo bs_input("Nomor Telepon", "required", null, "phone"); ?>
                        <?php echo bs_input("Kata Sandi", "required", null, "password", 'password'); ?>
                        <?php echo bs_input("Konfirmasi Kata Sandi", "required", null, "password"); ?>
<!--                         <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <?php $user = array("aktif", "tidak aktif");
                                foreach ($user as $data) {
                                    ?>
                                    <option value="<?php echo strtolower($data); ?>"><?php echo $data; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>   -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info" type="submit"> TAMBAH</button>
            </div>
        </form>
        <?php echo px_validate(
            'kata_sandi: "required",
            konfirmasi_kata_sandi: {
            equalTo: "#password"
            }')?>
    </div>
</div>
