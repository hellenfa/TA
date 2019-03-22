<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
					aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Warning</h4>
		</div>
		<?php echo form_open( base_url( $uri) ) ?>
		<input type="hidden" name="_method" value="DELETE">
		<div class="modal-body text-center">
			<span class="fa fa-exclamation-triangle fa-5x" style="color: orange"></span>
			<h3>Are you sure you want to delete <?php echo  $judul ?> ?</h3>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-danger">Delete</button>
			</div>
			<?php echo form_close() ?>
		</div>
	</div>
</div>