<?php


class DT_Kriteria_model extends Datatable_Model
{
    var $table = 'kriteria';

    var $search_column = array(
        'kriteria_name'
    );
    var $select_column = array(
        'kriteria.id_kriteria',
        'kriteria_name',
    );
    var $order_column = array(
        'kriteria_name',
    );

    public function set_kriteria($id)
    {
        // $this->where='id_subkegiatan='.$id;
        $this->where=[
            'id_kriteria'=>$id
        ];
    }

}
