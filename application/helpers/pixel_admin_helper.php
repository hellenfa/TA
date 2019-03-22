<?php
if (!function_exists('datatable')) {
    function datatable($title = null, $uri, $id = 'jq-datatables-example', $orderable = true, $order=array(), $other='')
    {
        $ord = '';
        if (count($order) > 0){
            $ord = '['.$order[0].',"'.$order[1].'"]';
        }
        $ci =& get_instance();
        $init = 'pxInit.push(function () {';
        if ($ci->input->is_ajax_request()) {
            $init = '$(function (){';
        }
        return '<script>'.$init.'$("#' . $id . '").dataTable({
            "language" : {
                "url" : "' . base_url('assets/admin_lte/plugins/datatables/language/Indonesian.json') . '",
                "searchPlaceholder": "Cari.."
            },
             "ordering": ' . $orderable . ',
            "processing" : true,
            "serverSide" : true,
            "order" : ['.$ord.'],
            "ajax" : {
            url : "' . site_url($uri) . '",
                type : "POST"
            },
            "columnDefs":[
                {
                    "targets" : "no-sort",
                    "orderable" :  false
                }
            ],'.$other.'
        });
        $("#' . $id . ' .table-caption").text("' . $title . '");
        $("#' . $id . ' .dataTables_filter input").attr("placeholder", "Cari...");
    });
</script>';
    }
}
if (!function_exists('make_query')) {
    function make_query($table, $select_column = array(), $search_column = array(), $order_column = array(), $join_table = array(), $pk = 'id')
    {
        $ci =& get_instance();
        $ci->db->select($select_column)->from($table);
        if (count($join_table) > 0) {
            foreach ($join_table as $item) {
                $ci->db->join($item[0], $item[1]);
            }
        }
        if (isset($_POST['search']['value'])) {
            $where = $search_column[0] . ' LIKE "%' . $_POST['search']['value'] . '%"';
            if (count($search_column) > 1) {
                for ($i = 1; $i <= (count($search_column) - 1); $i++) {
                    $where .= ' OR ' . $search_column[$i] . ' LIKE "%' . $_POST['search']['value'] . '%"';
                }
            }
            $ci->db->where("(" . $where . ")");
        }
        if (isset($_POST['order'])) {
            $ci->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $ci->db->order_by($table . '.' . $pk, 'desc');
        }

    }
}

if (!function_exists('datepicker')) {
    function datepicker($id = 'datepicker')
    {
        return '<script src="' . base_url('assets/js/bootstrap-datepicker.ID.js') . '"></script><script>$(function() {$("#' . $id . '").datepicker({"autoclose": true,"format": "dd-mm-yyyy","language": "ID"});});</script>';
//      return '<script>pxInit.push(function () {$("#' . $id . '").datepicker({"autoclose": true,"format": "dd-mm-yyyy"});});</script>';
    }
}

if (!function_exists('select2')) {
    function select2($id, $api, $api_id, $api_value, $placeholder = '')
    {
        $ci =& get_instance();
        $init = 'pxInit.push(function () {';
        if ($ci->input->is_ajax_request()) {
            $init = '$(function (){';
        }
        return '<script>'.$init.'$("#' . $id . '").select2({
            placeholder: "' . $placeholder . '",
            minimumInputLength: 1,
            ajax: {
            url: "' . $api . '",
                type: "GET",
                dataType: "json",
                delay: 250,
                cache: true,
                data: function (params) {
                return {q: params};
                },
                results: function (data, page ) {
                var results = [];
                $.each(data, function (index, item) {
                    results.push({id: item.' . $api_id . ', text: item.' . $api_value . '});
                        });
                console.log(results);
                return {results: results};
                }
            }
        }); }); </script>';
    }
}

if (!function_exists('nav_menu')) {
    function nav_menu($nama, $uri = '#', $active = null, $icon = 'fa-circle-o', $array_submenu = array())
    {
        if ($array_submenu == null) {

            return '<li class="px-nav-item ' . $active . '"><a href="' . base_url($uri) . '"><i class="fa ' . $icon . '"></i> <span> &nbsp;' . $nama . '</span></a></li>';
        } else {
            $submenu = '<li class="px-nav-item ' . $array_submenu[0]['active'] . '"><a href="' . base_url($array_submenu[0]['uri']) . '"><i class="fa fa-circle-o"></i> &nbsp;' . $array_submenu[0]['nama'] . '</a></li>';
            for ($i = 1; $i < count($array_submenu); $i++) {
                $submenu .= '<li class="px-nav-item ' . $array_submenu[$i]['active'] . '"><a href="' . base_url($array_submenu[$i]['uri']) . '"><i class="fa fa-circle-o"></i> &nbsp;' . $array_submenu[$i]['nama'] . '</a></li>';
            }
        }

        return '<li class="px-nav-item px-nav-dropdown"> <a href = "' . base_url($uri) . '" ><i class="fa ' . $icon . '" ></i > <span > &nbsp;' . $nama . '</span ></span></a><ul class="px-nav-dropdown-menu" >' . $submenu . '</ul></li > ';
    }
}

if (!function_exists('edit_button')) {
    function edit_button($uri)
    {
        return '<a href="' . base_url($uri) . '" class="btn btn-xs btn-warning"><span class="fa fa-pencil"></span> Edit</a>';
    }
}

if (!function_exists('print_button')) {
    function print_button($uri)
    {
        return '<a href="' . base_url($uri) . '" class="btn btn-xs btn-default"><span class="fa fa-print"></span>&nbsp; Cetak</a>';
    }
}

if (!function_exists('cancel_button')) {
    function cancel_button($uri)
    {
        return '<a href="' . base_url($uri) . '" class="btn btn-xs btn-default"><span class="fa fa-times"></span>&nbsp; Batal Terbit</a>';
    }
}

if (!function_exists('px_validate')) {
    function px_validate($rules = '', $id = 'validation-form')
    {
        $ci =& get_instance();
        if ($ci->input->is_ajax_request()) {
            return "<script>$(function() {
        $('#" . $id . "').pxValidate({ ignore: '.ignore, .select2-input',focusInvalid: false,rules: {" . $rules . "}});
        });</script><script type='text/javascript' src='" . base_url('/') . "assets/js/jquery-validate/localization/messages_id.js'></script>";
        } else {
            return "<script>pxInit.push(function() {
        $('#" . $id . "').pxValidate({ ignore: '.ignore, .select2-input',focusInvalid: false,rules: {" . $rules . "}});
        });</script><script type='text/javascript' src='" . base_url('/') . "assets/js/custom-validate.js'></script>";

        }
    }
}

if (!function_exists('select2_v2')) {
    function select2_v2($id = 'select2')
    {
        return "<script>pxInit.push(function() { $('" . $id . "').select2({placeholder: 'Select value',}); });</script>";
    }
}