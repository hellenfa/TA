<div class="modal-dialog" role="document">
    <div class="modal-content" style="height: 500px">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            <h4 class="modal-title"><?php echo $doc_name ?>&nbsp;&nbsp;
                <?php if ($download == 1) { ?>
                    <a href="<?php echo base_url('dokumentasi/get_document') . '/' . $id ?>"
                       download="<?php echo $doc_name ?>"><i class="fa fa-download"></i></a>
                <?php } ?>
            </h4>
        </div>
        <?php if ($download == 1) { ?>
            <?php echo '<iframe src="' . base_url('dokumentasi/get_document') . '/' . $id . '" id="iframe" style="border: none;" width="100%" height="100%"></iframe>'; ?>
        <?php } else { ?>
            <?php echo '<iframe src="' . base_url('dokumentasi/get_document') . '/' . $id . '?page=hsn#toolbar=0" frameborder="0" scrolling="no" id="iframe" class="disableRightClick" style="border: none;" width="100%" height="100%" style="pointer-events:none;"></iframe>'; ?>

        <?php } ?>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<script language="javascript">
    document.onmousedown = disableclick;
    status = "Right Click Disabled";
    function disableclick(e)
    {
        if (event.button == 2) {
            alert(status);
            return false;
        }
    }
    #toolbarButton
</script>
<script type="text/javascript">
    var iframe = document.getElementById('iframe')
    $(document).on('keydown', function (e) {
        if (e.ctrlKey && (e.key == "p" || e.charCode == 16 || e.charCode == 112 || e.keyCode == 80)) {
            e.cancelBubble = true;
            e.preventDefault();
            e.stopImmediatePropagation();
        }
    });
</script>
>>>>>>> 4760e8025fdcfde9275087258793be440b977c77
