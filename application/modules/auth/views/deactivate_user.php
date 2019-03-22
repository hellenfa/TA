<div class="panel">
    <div class="panel-heading">
        <h1 class="panel-title">Deaktivasi Pengguna</h1>
    </div>
    <div class="panel-body">
        <p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>
	    <?php echo form_open("auth/deactivate/".$user->id,array('class' => 'form'));?>
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <input type="radio" name="confirm" value="yes" checked="checked" />
				    <?php echo lang('deactivate_confirm_y_label', 'confirm');?>
                    <br>
                    <input type="radio" name="confirm" value="no" />
				    <?php echo lang('deactivate_confirm_n_label', 'confirm');?>
                </div>
            </div>
        </div>

	    <?php echo form_hidden($csrf); ?>
	    <?php echo form_hidden(array('id'=>$user->id)); ?>

        <button type="submit" class="btn btn-primary">Submit</button>
	    <?php echo form_close();?>
    </div>
</div>