<script>
	<?php if (isset($message)){ ?>
    $.growl({ message: "<?php echo $message; ?>" });
	<?php } ?>
</script>