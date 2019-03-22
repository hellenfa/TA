<a target="ajax-modal" href="<?php echo base_url()?>auth/create_user" class="btn btn-primary btn-lg"><span class="fa fa-user-plus"></span>&nbsp; Tambah Pengguna Baru</a>&nbsp;&nbsp;
<a href="<?php echo base_url()?>auth/create_group" class="btn btn-primary btn-lg"><span class="fa fa-user-plus"></span>&nbsp; Tambah Grup Baru</a>
<br><br>

<div class="panel">
    <div class="panel-heading">
        <h1 class="panel-title"></h1>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-striped">
            <tr>
                <th>Nama Publikasi</th>
                <th>Email</th>
                <th>Grup</th>
                <th>Status</th>
                <th>Opsi</th>
            </tr>
			<?php foreach ($users as $user):?>
                <tr>
                    <td><?php echo htmlspecialchars($user->nama_lengkap,ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
                    <td>
						<?php foreach ($user->groups as $group):?>
							<?php echo anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8'),array('class' => 'btn btn-xs btn-primary')) ;?>
						<?php endforeach?>
                    </td>
                    <td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link'),array('class' => 'btn btn-xs btn-primary')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'),array('class' => 'btn btn-xs btn-danger'));?></td>
                    <td><?php echo anchor("auth/edit_user/".$user->id, 'Edit',array('class' => 'btn btn-xs btn-warning')) ;?></td>
                </tr>
			<?php endforeach;?>
        </table>
    </div>
    <div class="panel-footer">
        <?php echo $pagination; ?>
    </div>
</div>