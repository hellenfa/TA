<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">
                <center>UBAH DATA PENGGUNA</center>
            </h4>
        </div>
        <form class="form-horizontal" action="<?php echo base_url(); ?>user/edit/<?php echo $users->id ?>" method="post"
              role="form" id="validation-form">
            <div class="modal-body" id="modal-edit">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label>Tipe</label>
                            <select name="tipe" class="form-control">
                                <?php
                                $user = array("admin", "pegawai");
                                foreach ($user as $data){
                                    ?>
                                    <option value="<?php echo $data; ?>"<?php echo ($users->type==$data) ? "selected" : ";" ?> ><?php echo $data ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <?php echo bs_input("Nama Pengguna", "required", $users->username, $users->id, "username"); ?>
                         <?php echo bs_input("Nama depan", "required", $users->first_name, $users->id, "first_name"); ?>
                        <?php echo bs_input("Nama Belakang", "required", $users->last_name, $users->id, "last_name"); ?>
                        <?php echo bs_input("Email", "required", $users->email, $users->id, "email"); ?>
                        <?php echo bs_input("Nomor Telepon", "required", $users->phone, $users->id, "phone"); ?>
                       <?php echo bs_input("Kata Sandi Baru", '', null, "password", 'password'); ?>
                        <?php echo bs_input("Konfirmasi Kata Sandi Baru", '', null, "password"); ?>
            <div class="modal-footer">
            <a class="btn btn-secondary" data-dismiss="modal">Batal</a>
            <button class="btn btn-info" type="submit"> Simpan</button>
      </div>
        </form>
        <?php echo px_validate(
        'kata_sandi_baru: "",
        konfirmasi_kata_sandi_baru: {
        equalTo: "#password"}')?>
        
    </div>
</div>
