<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            <h4 class="modal-title"><?php echo $doc_name ?>&nbsp;&nbsp;
                <?php if($download==1){?>
                    <a href="<?php echo base_url('logbook/get_document') . '/' . $id ?>" download="<?php echo $doc_name ?>"><i class="fa fa-download"></i></a>
                <?php } else { ?>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                    <script type="text/javascript">
                        jQuery(document).ready(function(){
                            jQuery(function() {
                                jQuery(this).bind("contextmenu", function(event) {
                                    event.preventDefault();
                                });
                            });
                        })
                    </script>
                    <script type="text/javascript">
                        $(document).on('keydown', function(e) {
                            if(e.ctrlKey && (e.key == "p" || e.charCode == 16 || e.charCode == 112 || e.keyCode == 80) ){
                                e.cancelBubble = true;
                                e.preventDefault();
                                e.stopImmediatePropagation();
                            }
                        });
                    </script>
                <?php } ?>
            </h4>
        </div>
        <?php echo '<img src="' . base_url('logbook/get_document') . '/' . $id . '" style="width:100%;">' ?>
    </div>
</div>
