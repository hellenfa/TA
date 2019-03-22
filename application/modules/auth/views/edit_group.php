<div class="panel box-primary">
    <div class="panel-heading ">
        <h1 class="panel-title">Ubah Grup</h1>
    </div>
    <div class="panel-body">
        <p><?php echo lang('edit_group_subheading');?></p>
        <div id="infoMessage"><?php echo $message;?></div>
        <?php echo form_open(current_url());?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo lang('edit_group_name_label', 'group_name');?> <br />
                    <?php echo form_input($group_name);?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo lang('edit_group_desc_label', 'description');?> <br />
                    <?php echo form_input($group_description);?>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <?php echo form_close();?>
    </div>
</div>
