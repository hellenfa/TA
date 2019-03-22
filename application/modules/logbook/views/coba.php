<div class="modal   fade" tabindex="-1" data-focus-on="input:first" role="dialog" id="addModal" style="height: 100%">
                    <div class="modal-dialog" style="width: 100%">
                        <div class="modal-content" style="width: 100%">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss-modal="#addModal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <label class="modal-title center-block" style="color:red; font-size:larger"></label>
                            </div>
                            <div class="modal-body">
                                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#VehModal">
  Launch nested modal
</button>
                                
                                <div class="modal " tabindex="-2"   id="VehModal">
                                    <div class="modal-dialog" style="width: 100%">
                                        <div class="modal-content" style="width: 100%">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss-modal="#VehModal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <label class="modal-title center-block" style="color:red; font-size:larger">Choix de véhicule</label>
                                            </div>
                                            <div class="modal-body">
                                                <p><label id="labchauffeurs">Chauffeurs disponibles</label> <select id="lstchauffeurs" name="lstchauffeurs" style="width:250px;  "></select>  </p>
                                                <p>
                                                    <table id="tblauto" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr style="color:white;background-color:#3c8dbc" id="autoheader">

                                                                <th></th>
                                                                <th>Chauffeur</th>
                                                                <th>Marque</th>
                                                                <th>Plaque d’immatriculation</th>
                                                                <th>Kilométrage</th>
                                                                <th>Année de fabrication</th>
                                                                <th>Carte de carburant </th>
                                                                <th>Observation</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody id="tblautoBody"></tbody>

                                                    </table>
                                                </p>

                                               </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnSetVehicle">Valider</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal" id="btnQuit">Annuler</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal" id="btnEscape">Quitter</button>
                            </div>
                        </div>
                    </div>
                </div>


<a href="logbook/edit/" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addModal">
  Edit
</a>
<script>
$(document).on('click', '[data-dismiss-modal]', function () {
    var target = $(this).attr('data-dismiss-modal');
    $(target).modal('hide');
});
    </script>