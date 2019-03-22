 <div class="modal-dialog" role="document">
    <div class="modal-content" style="height: 500px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title"><?php echo $doc_name ?>&nbsp;&nbsp;
          <a href="<?php echo base_url('recycle_bin/get_document') . '/' . $id ?>" download="<?php echo $doc_name ?>"><i class="fa fa-download"></i></a>
        </h4>
      </div>
        <?php echo '<iframe src="' . base_url('recycle_bin/get_document') . '/' . $id . '" id="iframe" style="border: none;" width="100%" height="100%"></iframe>'; ?>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>