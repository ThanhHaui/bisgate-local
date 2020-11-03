<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mtonnages extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "tonnages";
        $this->_primary_key = "TonnageId";
    }
    public function html($id,$vehicleTonage)
    {
        $listValue = $this->Mtonnages->getFieldValue(array('TonnageId' => $id), 'UnitName', '');
        $value = $this->Mtonnages->getFieldValue(array('TonnageId' => $id), 'UnitVallues', '');
        $listValue = json_decode($listValue, true);
        $name = '';
        if ($listValue == 1) {
            $name = 'Tấn';
        }
        if ($listValue == 2) {
            $name = 'Người';
        }
        $value = explode(",", $value);;
        $html = '';
        $html .= '<option value="0">--- Trọng tải ---</option>';
        foreach ($value as $k => $item) {
            if($item == $vehicleTonage){
                $html .= '<option value="' . $item . '" selected >' . $item . ' ' . $name . '</option>';

            }
            else{

                $html .= '<option value="' . $item . '"  >' . $item . ' ' . $name . '</option>';
            }
        }
        return $html;
    }
}