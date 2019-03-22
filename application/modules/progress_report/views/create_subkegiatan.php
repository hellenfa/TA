<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">CREATE SUBACTIVITY</h4>
        </div>
        <form class="form-horizontal" autocomplete="off"
              action="<?php echo base_url('progress_report/create_subkegiatan') . '/' . $id ?>"
              method="post" enctype="multipart/form-data" role="form" id="validation-form">
            <div class="modal-body" style="margin: 20px;">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo bs_input("Subactivity Name"); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Auction Type</label>
                            <select class="form-control" name="jenis_lelang" onchange=get_string(this.value)>
                                <option value=""></option>
                                <?php foreach ($jenis_lelang as $data) { ?>
                                    <option value="<?php echo $data->id_jenis_lelang; ?>"><?php echo $data->jenis_lelang_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Detail subkegiatan</th>
                                    <th>Plan Start</th>
                                    <th>Plan Finish</th>
                                    <th>Staff</th>
                                    <th>Verificator</th>
                                </tr>
                                </thead>
                                <tbody id="nama"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info" type="submit"> ADD</button>
            </div>
        </form>
        <?php echo px_validate("
        'nama_subkegiatan': {
            maxlength: 190,
         },
          "); ?>
    </div>
</div>

<script>
    var user = [];

    function get_string(id) {
        $.ajax({
            type: "GET",
            url: "<?php echo base_url() . 'progress_report/get_string_detail_subkegiatan';?>",
            data: {
                "id": id
            },
            dataType: 'json',
            success: function (data) {
                $('#nama').html('');
                $.each(data.users, function (i, v) {
                    var temp = [];
                    temp['id'] = v.id;
                    temp['text'] = v.first_name + ' ' + v.last_name;
                    user.push(temp)
                });

                $.each(data, function (i, v) {
                    var _html = '<tr>' +
                        '<td>' +
                        '<input  type="hidden" name="id_jenis_lelang[]" value="' + v.id_jenis_lelang + '">' +
                        '<input type="text" readonly name="nama_sub_kegiatan[]" value="' + v.tahap_lelang_name + '">' +
                        '</td>' +
                        '<td>' +
                        '<input class="date-pick" type="text" name="plan_start[]" required>' +
                        '</td>' +
                        '<td>' +
                        '<input class="date-pick" type="text" name="plan_finish[]" required>' +
                        '</td>' +
                        '<td>' +
                        '<select name="akses[]" class="form-control select2-example" multiple="">'
                        + user +
                        '</select>' +
                        '</td>' +
                        '</tr>';
                    $('#nama').append(_html);
                });

                $(".select2-example").select2({
                    placeholder: 'Select user'
                });
            }
        });
    }

    $(function () {
        $(document).on('click', '.date-pick', function () {
            $(this).datepicker().focus();
            $(this).removeClass('date-pick');
        });
        $(document).on('click', '.select2-example', function () {
            $(this).select2({
                placeholder: 'Select user',
                data: user
            });
            $(this).removeClass('select2-example');
        });
    });
</script>