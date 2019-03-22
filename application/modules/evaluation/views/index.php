<!-- <div class="row">
    <div class="col-md-12">
        <?php if($this->ion_auth->user()->row()->type=='pegawai fakultas'){?>
            <a href="<?php echo base_url('dokumentasi/create') ?>" id="btnAdd" target="ajax-modal" class="btn btn-info btn-lg"><span class="fa fa-plus"></span>&nbsp; ADD FOLDER</a>
            <br><br>
        <?php } ?>
    </div>
</div> -->
<div class="panel panel-warning">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-warning"></i>&nbsp;Warning
          <div class="pull-right"> <a href="#" data-perform="panel-dismiss" class="btn btn-warning btn-xs pull-right"><i class="fa fa-times"></i></a> <a href="#" data-perform="panel-collapse" class="btn btn-warning btn-xs pull-right"><i class="fa fa-minus"></i></a> </div>
        </h4>
    </div>
    <div class="panel-wrapper collapse in">
            <div class="panel-body">
            Please click <button type="button" class="btn btn-info btn-xs"><i class="fa fa-save"></i>&nbsp;Save</button> after fill the Evaluation. </br>
            </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Kriteria 1. Relevance</h1>
    </div>

    <div class="panel-wrapper collapse in">
      <div class="panel-body">
        Relevansi kebutuhan pengembangan saat pengajuan dan kondisi saat ini serta konsistensi terhadap kebijakan pengembangan Pemerintah Indonesia (UGM) dan Pemerintah Jepang (JICA). </br>
        <br/>
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#penilaian">PENILAIAN</a></li>
          <li><a data-toggle="tab" href="#upload">UPLOAD DOKUMEN</a></li>
        </ul>

        <div class="tab-content">
          <div id="penilaian" class="tab-pane fade in active">
            <strong>1.1 Rasionalitas Kajian Akademik</strong> </br>
            asdf

            </br></br>
            <strong>Uraian</strong> </br>
            asdf

            </br></br>
            <strong>Komentar Reviewer</strong> </br>
            asdf

          </div>


          <div id="upload" class="tab-pane fade">
            <h3>UPLOAD DOKUMEN</h3>
              <p>Tutorial pemrograman web, mobile dan design</p>
          </div>
        </div>
    </div>

    <div class="panel-body">
        <table id="jq-datatables-example" class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Folder Name</th>
                <th>Date Created</th>
                <?php if($this->ion_auth->user()->row()->type=='pegawai fakultas'){?>
                <th class="no-sort">Action</th>
                <?php } ?>
            </tr>
            </thead>
        </table>
    </div>
</div>

<!-- <div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Documentation</h1>
    </div>
    <div class="panel-body">
        <table id="jq-datatables-example" class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Folder Name</th>
                <th>Date Created</th>
                <?php if($this->ion_auth->user()->row()->type=='pegawai fakultas'){?>
                <th class="no-sort">Action</th>
                <?php } ?>
            </tr>
            </thead>
        </table>
    </div>
</div> -->
<?php echo datatable("Evaluation", 'evaluationi/fetch_data'); ?>
