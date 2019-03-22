<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Log</h4>
        </div>
            <div class="modal-body">
                <div class="panel-body">
                    <table id="jq-log" class="table table-striped table-hover">
                        <thead>
                            <tr>
                               <!--  <th>Name</th>
                                <th>Name</th> -->
                                <th>Username</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
<?php echo datatable("Dokumentasi", 'dokumentasi/fetch_data_log_document/'.$id,'jq-log'); ?>