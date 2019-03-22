<div class="modal-dialog" role="document">
    <div class="modal-content" style="height: 500px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title"><?php echo $attach_name ?>&nbsp;&nbsp;
        <?php if($download==1){?>
          <a href="<?php echo base_url('logbook/get_attachment') . '/' . $id ?>" download="<?php echo $attach_name ?>"><i class="fa fa-download"></i></a>
          <?php } ?>
        </h4>
      </div>
      <?php if($download==1){?>
        <?php echo '<iframe src="' . base_url('logbook/get_attachment') . '/' . $id . '" id="iframe" style="border: none;" width="100%" height="100%"></iframe>'; ?>
      <?php } else { ?>
        <?php echo '<iframe src="' . base_url('logbook/get_attachment') . '/' . $id . '?page=hsn#toolbar=0" frameborder="0" scrolling="no" id="iframe" class="disableRightClick" style="border: none;" width="100%" height="100%" style="pointer-events:none;"></iframe>'; ?>
        
      <?php } ?>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
