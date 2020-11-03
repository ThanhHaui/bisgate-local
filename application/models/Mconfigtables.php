<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mconfigtables extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "configtables";
        $this->_primary_key = "ConfigTableId";
    }

    public function genHtmlThTable($controller, $userId = 0){
        $query = "SELECT *, configtables.ConfigTableId as ConfigTableId_1 FROM `configtables` LEFT JOIN configtableusers ON configtableusers.ConfigTableId = configtables.ConfigTableId WHERE configtables.TableName = ?";
        $tableTh = $this->getByQuery($query, array($controller));
        $htmlTableTh = '';
        $json = array();
        $countIsLock = 0;
        if($tableTh){
            $configTableUserId = 0;

            if($tableTh[0]["ConfigTableUserId"] != NULL AND $tableTh[0]["UserId"] == $userId) $configTableUserId = $tableTh[0]["ConfigTableUserId"];
            if($tableTh[0]["TableUserJson"] != NULL) $json = json_decode($tableTh[0]["TableUserJson"], true);
            else $json = json_decode($tableTh[0]["ConfigTableJson"], true);
            $htmlTableTh = '<tr class="dnd-moved" data-id="'.$tableTh[0]['ConfigTableId_1'].'" config-table-user-id="'.$configTableUserId.'">';
            for($y = 0; $y < count($json); $y++){
                $displayNone = '';
                if($json[$y]['IsActive'] == 'OFF'){
                    $displayNone = 'display:none';
                }
                $value = "column-name='".$json[$y]['ColumnName']."' name-user='".$json[$y]['ColumnNameUser']."' modals-db='".$json[$y]['ModelsDb']."' status='".$json[$y]['Status']."' edit='".$json[$y]['Edit']."' id-edit='".$json[$y]['IdEdit']."' number='".$json[$y]['Number']."' name-relationship='".$json[$y]['NameRelationship']."' date-time='".$json[$y]['DateTime']."' is-active='".$json[$y]['IsActive']."' is-lock='".$json[$y]['IsLock']."' ";
                if($json[$y]['ColumnName'] == 'Check'){
                    $htmlTableTh .= '<th style="'.$displayNone.'" class="th_'.$y.' th_move fix_width" '.$value.'><input type="checkbox" class="iCheckTable" id="checkAll"></th>';
                }else{
                    $htmlTableTh .= '<th style="'.$displayNone.'" class="th_'.$y.' th_move" '.$value.' >'.$json[$y]['ColumnNameUser'].'</th>';
                }
                
            }

            for($y = 0; $y < count($json); $y++){
                if($json[$y]['IsLock'] == 'ON'){
                    $countIsLock = $y + 1;
                    break;
                }else{
                    $countIsLock = 0;
                }
            }
            $htmlTableTh .= '</tr>';
        }
        return array('htmlTableTh' => $htmlTableTh, 'tableTh' => $json, 'countIsLock' => $countIsLock);
        
    }
}