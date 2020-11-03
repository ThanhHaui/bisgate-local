<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Magents extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "agents";
        $this->_primary_key = "AgentId";
    }

    public function searchByFilter($searchText, $itemFilters, $limit, $page, $staffId)
    {
        $queryCount = "select staffs.StaffId AS totalRow from staffs {joins} where {wheres}";
        $query = "select {selects} from staffs {joins} where {wheres} ORDER BY staffs.CrDateTime DESC LIMIT {limits}";

        $selects = [
            'staffs.*',
        ];
        $joins = [
        ];

        $wheres = array('staffs.StaffId > 0 AND staffs.StatusId > 0 ');
        $wheres = array('staffs.StaffTypeId = 1 OR staffs.StaffTypeId = 2 ');
        $dataBind = [];
        $whereSearch = '';
        $searchText = strtolower($searchText);
        //search theo text
        if (!empty($searchText)) {
            if (preg_match('/\d{4}-\d{2}-\d{2}/im', $searchText)) {
                $whereSearch = 'staffs.CrDateTime like ?';
                $dataBind[] = "$searchText%";
            } else {
                $whereSearch = 'staffs.StaffName like ? or staffs.FullName like ? or staffs.ShortName like ? or staffs.Email like ? or staffs.PhoneNumber like ? ';
                for ($i = 0; $i < 5; $i++) $dataBind[] = "%$searchText%";
            }
        }
        if (!empty($whereSearch)) {
            $whereSearch = "( $whereSearch )";
            $wheres[] = $whereSearch;
        }
        //search theo bộ lọc ,
        if (!empty($itemFilters) && count($itemFilters)) {
            foreach ($itemFilters as $item) {
                $filed_name = $item['field_name'];
                $conds = $item['conds'];
                // $cond[0] là điều kiện ví dụ : < > = like .....   $cons[1] và $cond[2]  là gía trị điều kiện như 2017-01-02 và 2017-01-01
                switch ($filed_name) {
                    case 'status_id':
                        $wheres[] = "staffs.StatusId $conds[0] ?";
                        $dataBind[] = $conds[1];
                        break;
                    case 'licence_type_id':
                        $wheres[] = "userdetails.LicenceTypeId $conds[0] ?";
                        $dataBind[] = $conds[1];
                        break;
                    default :
                        break;
                }
            }
        }
        $selects_string = implode(',', $selects);
        $wheres_string = implode(' and ', $wheres);
        $joins_string = implode(' ', $joins);
        $query = str_replace('{selects}', $selects_string, $query);
        $query = str_replace('{joins}', $joins_string, $query);
        $query = str_replace('{wheres}', $wheres_string, $query);
        $query = str_replace('{limits}', $limit * ($page - 1) . "," . $limit, $query);
        $queryCount = str_replace('{joins}', $joins_string, $queryCount);
        $queryCount = str_replace('{wheres}', $wheres_string, $queryCount);
        if (count($wheres) == 0) {
            $query = str_replace('where', '', $query);
            $queryCount = str_replace('where', '', $queryCount);
        }
        $controller = 'agent';
        $dataConfigTable = $this->Mconfigtables->genHtmlThTable('' . $controller . '', $staffId);
        $tables = $dataConfigTable['tableTh'];

        $now = new DateTime(date('Y-m-d'));
        $datas = $this->getByQuery($query, $dataBind);
        $html = '';

        for ($i = 0; $i < count($datas); $i++) {
            $html .= '<tr id="trItem_' . $datas[$i]['StaffId'] . '" class="dnd-moved trItem ">';
            for ($z = 0; $z < count($tables); $z++) {
                $displayNone = '';
                if ($tables[$z]['IsActive'] == 'OFF') {
                    $displayNone = 'display:none';
                }
                $columnName = $tables[$z]['ColumnName'];
                if ($columnName == 'Check') {
                    $html .= '<td style="' . $displayNone . '" class="fix_width"><input class="checkTran iCheckTable iCheckItem" type="checkbox" value="' . $datas[$i]['StaffId'] . '"></td>';
                } else if (!empty($tables[$z]['Status']) && $tables[$z]['Status'] != NULL) {
                    $arrStatus = $this->Mconstants->$columnName;
                    $nameStatus = $datas[$i][$tables[$z]['Status']] > 0 ? $arrStatus[$datas[$i][$tables[$z]['Status']]] : '';
                    if ($nameStatus) {
                        $labelCss = $this->Mconstants->labelCss;
                        $statusId = $datas[$i][$tables[$z]['Status']];
                        $html .= '<td style="' . $displayNone . '" class="text-center" id="show_and_hide_3"><span class="' . $labelCss[$statusId] . '">' . $nameStatus . '</span></td>';
                    } else {
                        $html .= '<td style="' . $displayNone . '" class="text-center"></td>';
                    }

                } else if (!empty($tables[$z]['DateTime'])) {
                    if ($columnName == 'BirthDay') {
                        $html .= '<td style="' . $displayNone . '" >' . ddMMyyyy($datas[$i][$columnName]) . '</td>';
                    } else {
                        $dayDiff = getDayDiff($datas[$i][$columnName], $now);
                        $crDateTime = ddMMyyyy($datas[$i][$columnName], $dayDiff > 2 ? 'd/m/Y H:i' : 'H:i');
                        $html .= '<td style="' . $displayNone . '" >' . getDayDiffText($dayDiff) . $crDateTime . '</td>';
                    }
                } else if (!empty($tables[$z]['Edit']) && !empty($tables[$z]['IdEdit'])) {
                    // $html .= '<td style="'.$displayNone.'" ><a href="javascript:void(0)" class="link_edit" data-id="'.$datas[$i]['StaffId'].'" link-url="'.$tables[$z]['Edit'].'">'.$datas[$i][$columnName].'</a></td>';
                    $html .= '<td style="' . $displayNone . '" ><a href="' . $tables[$z]['Edit'] . '/' . $datas[$i]['StaffId'] . '">' . $datas[$i][$columnName] . '</a></td>';
                } else if (!empty($tables[$z]['ModelsDb']) || !empty($tables[$z]['NameRelationship'])) {
                    $models = $tables[$z]['ModelsDb'];
                    $nameRelationship = $tables[$z]['NameRelationship'];
                    $this->load->model($models);
                     if ($columnName == 'AgentId') {
                        $data = $this->$models->getBy(array('AgentId' => $datas[$i]['StaffId'], 'AgentId >' => 0));
                        $html .= '<td style="' . $displayNone . '" >' . count($data) . '</td>';
                    } else if ($columnName == 'AgentTypeId') {
                        $data = $this->$models->getFieldValue(array($columnName => $datas[$i][$columnName]), 'AgentTypeName', '');
                        $html .= '<td style="' . $displayNone . '" >' . $data . '</td>';
                    } else if ($columnName == 'ManagementUnitId') {
                        if ($datas[$i][$columnName] == 1) {
                            $html .= '<td style="' . $displayNone . '" >' . $this->Mconstants->agentLevelId[$datas[$i][$columnName]] . '</td>';
                        } else {
                            $data = $this->$models->getFieldValue(array('StaffId' => $datas[$i][$columnName]), 'FullName', '');
                            $html .= '<td style="' . $displayNone . '" ><span class="primary">' . $data . '</span></td>';
                        }
                    } else if ($columnName == 'UserId') {
                        $data = $this->$models->getCount(array('ManagementUnitId' => $datas[$i][$nameRelationship]));
                        $html .= '<td style="' . $displayNone . '" >' . $data . '</td>';
                    }
                    else if ($columnName == 'VehicleId') {
                        $data = $this->$models->getCountAgentVehicle($datas[$i][$nameRelationship]);
                         $html .= '<td style="' . $displayNone . '" >' . $data . '</td>';
                        }
                    else {      
                        $data = $this->$models->getFieldValue(array($columnName => $datas[$i][$columnName]), $nameRelationship, '');
                        $html .= '<td style="' . $displayNone . '" >' . $data . '</td>';
                    }
                } else {
                    if ($columnName == 'AgentLevelId') {
                        $html .= '<td class="agent_level agent_level_' . ((int)$datas[$i][$columnName] - 1) . '" style="' . $displayNone . '" > <span>Đại lí cấp ' . ((int)$datas[$i][$columnName] - 1) . '</span></td>';
                    } else {
                        $html .= '<td style="' . $displayNone . '" ></td>';
                    }
                }
            }
            $html .= '</tr>';
        }
        $data = array();
        $totalRows = $this->getByQuery($queryCount, $dataBind);
        $totalRow = count($totalRows);
        $totalIds = array();
        foreach ($totalRows as $v) $totalIds[] = intval($v['totalRow']);
        $pageSize = ceil($totalRow / $limit);
        $data['dataTables'] = array('htmlTableTh' => $dataConfigTable['htmlTableTh'], 'dataTables' => $html, 'countIsLock' => $dataConfigTable['countIsLock']);
        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['pageSize'] = $pageSize;
        $data['callBackTable'] = 'renderContentDatas';
        $data['callBackTagFilter'] = 'renderTagFilter';
        $data['totalRow'] = $totalRow;
        $data['totalIds'] = json_encode($totalIds);
        $data['totalDataShow'] = count($datas);
        return $data;
    }
}