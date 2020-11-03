<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdeadlines extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->_table_name = "deadlines";
        $this->_primary_key = "DeadlineId";
    }

    public function update($postData = array(), $deadlineId = 0, $deadlinedetails = array(), $deadlinessls = array(), $commentDeadline = array(), $user = array(), $actionTypeId = 0) {
        $this->load->model('Mactionlogs');
        $actionLogs = array();
        $isUpdate = $deadlineId > 0 ? true : false;
        $this->db->trans_begin();
        $deadlineId = $this->save($postData, $deadlineId);
        if ($deadlineId > 0) {
            if ($postData['DeadlineStatusId'] == 2) { // trạng thái kích hoạt, và kích hoạt gia hạng cho ssls
                $postData['SSLStatusId'] = $postData['DeadlineStatusId'];
            }

            if ($isUpdate) {
                $this->db->delete('deadlinedetails', array('DeadlineId' => $deadlineId));
                $this->db->delete('deadlinessls', array('DeadlineId' => $deadlineId));
            } else {
                $this->db->update('deadlines', array('DeadlineCode' => $this->genCode($deadlineId, 'KHPM')), array('DeadlineId' => $deadlineId));

            }
            $this->load->model('Mdeadlinedetails');

            if (!empty($deadlinedetails)) {

                $arrDeadlineDetails = array();
                foreach ($deadlinedetails as $s) {
                    $countActive = $this->Mdeadlinedetails->countRows(array('DeadlineId' => $deadlineId, 'PackageId' => $s['PackageId']));
                    $s['DeadlineId'] = $deadlineId;
                    $s['PackagePrice'] = replacePrice($s['PackagePrice']);
                    $s['ExpiryDate'] = replacePrice($s['ExpiryDate']);

                    if ($postData['DeadlineStatusId'] == 2) {
                        $s['ActiveExpiryStartDate'] = getCurentDateTime();
                        $s['ActiveExpiryEndDate'] = date('Y-m-d H:i', strtotime("+" . $s['ExpiryDate'] . " month", strtotime($s['ActiveExpiryStartDate'])));
                    }
                    $arrDeadlineDetails[] = $s;
                }
                if (!empty($arrDeadlineDetails)) $this->db->insert_batch('deadlinedetails', $arrDeadlineDetails);
            }

            if (!empty($deadlinessls)) {
                $arrDeadlineSsls = array();
                foreach ($deadlinessls as $s) {
                    $s['DeadlineId'] = $deadlineId;
                    $arrDeadlineSsls[] = $s;
                }
                if (!empty($arrDeadlineSsls)) {
                    $deadlinessl = $this->db->insert_batch('deadlinessls', $arrDeadlineSsls);
                    if ($deadlinessl && $postData['DeadlineStatusId'] == 2) {
                        foreach ($deadlinessls as $s) {
                            $this->load->model('Mssls');
                            $this->load->model('Mssldetails');
                            $this->load->model('Mactionlogs');
                            $this->load->model('Mpackages');
                            $ssl = $this->Mssls->get($s['SSLId']);
                            if (in_array($ssl['SSLStatusId'], [1, 4])) {
                                if ($postData['PackageId'] > 0) {
                                    $commentLogSSL[] = 'trạng thái từ <strong>'.$this->Mconstants->sslStatus[$ssl['SSLStatusId']].'</strong> thành <strong>'.$this->Mconstants->sslStatus[2].'</strong>';
                                    $flagUpdateSSL = $this->Mssls->save(array(
                                        'SSLStatusId' => 2, // Bình thường
                                        'UpdateUserId' => $user['StaffId'],
                                        'ActiveExpiryStartDate' => $postData['ActiveExpiryStartDate'],
                                        'ActiveExpiryEndDate' => $postData['ActiveExpiryEndDate'],
                                        'UpdateDateTime' => getCurentDateTime()
                                    ), $ssl['SSLId']);

                                    if($flagUpdateSSL)  $this->Mactionlogs->saveLog($ssl['SSLId'], ID_LOG_SSL, ID_STATUS, $user, $commentLogSSL);
                                }

                                if (!empty($deadlinedetails)) {
                                    foreach ($deadlinedetails as $detail) {
                                        $ssldetails = $this->Mssldetails->getBy(array('SSLId' => $s['SSLId'], 'PackageId' => $detail['PackageId']));
                                        if ($postData['DeadlineStatusId'] == 2) {
                                            $detail['ActiveExpiryStartDate'] = getCurentDateTime();
                                            $detail['ActiveExpiryEndDate'] = date('Y-m-d H:i', strtotime("+" . $detail['ExpiryDate'] . " month", strtotime($detail['ActiveExpiryStartDate'])));
                                        }
                                        if(count($ssldetails) > 0) {
                                            $flagSSLDetail = $this->db->update('ssldetails', array(
                                                'SSLDetailStatusId' => 2,
                                                'ActiveExpiryStartDate' => $detail['ActiveExpiryStartDate'],
                                                'ActiveExpiryEndDate' => $detail['ActiveExpiryEndDate'],
                                                'UpdateUserId' => $user['StaffId'],
                                                'UpdateDateTime' => getCurentDateTime()
                                            ), array('SSLId' => $s['SSLId'], 'PackageId' => $detail['PackageId']));
                                            // $packageCode2 = $this->Mpackages->getFieldValue(array('PackageId' => $detail['PackageId']), 'PackageCode', '');
                                            // $logSSLDetail = array(
                                            //     'ItemTypeId' => 8,
                                            //     'CrUserId' => $user['StaffId'],
                                            //     'CrDateTime' => getCurentDateTime(),
                                            //     'ActionTypeId' => 2,
                                            //     'Comment' => $user['FullName'] . ': Vừa kích hoạt gia hạn gói PM mở rộng có mã: ' . $packageCode2,
                                            //     'ItemId' => $this->Mssldetails->getFieldValue(array('SSLId' => $s['SSLId'], 'PackageId' => $detail['PackageId']), 'SSLDetailId', 0),
                                            // );
                                            // $this->Mactionlogs->save($logSSLDetail);
                                        }else {
                                            $dataSSLdetailsSave = [
                                                'SSLId' => $s['SSLId'],
                                                'PackageId' => $detail['PackageId'],
                                                'SSLDetailStatusId' => 2,
                                                'ActiveExpiryStartDate' => $detail['ActiveExpiryStartDate'],
                                                'ActiveExpiryEndDate' => $detail['ActiveExpiryEndDate'],
                                            ];
                                            $this->Mssldetails->save($dataSSLdetailsSave);
                                        }
                                    }
                                } else {
                                    $listSSLDetails = $this->Mssldetails->getBy(array('SSLDetailStatusId' => 1, 'SSLId' => $s['SSLId']));
                                    foreach ($listSSLDetails as $detail2) {
                                        $this->db->update('ssldetails', array(
                                            'SSLDetailStatusId' => 2,
                                            'UpdateUserId' => $user['StaffId'],
                                            'UpdateDateTime' => getCurentDateTime()
                                        ), array('SSLId' => $s['SSLId'], 'SSLDetailId' => $detail2['SSLDetailId']));
                                    }
                                }

                            } else if ($ssl['SSLStatusId'] == 2) {

                                if ($postData['PackageId'] > 0) {
                                    $packageCode = $this->Mpackages->getFieldValue(array('PackageId' => $ssl['PackageId']), 'PackageCode', '');
                                    $this->Mssls->save(array(
                                        'ActiveExpiryEndDate' => date('Y-m-d H:i', strtotime("+" . $postData['ExpiryDate'] . " month", strtotime($ssl['ActiveExpiryEndDate']))),
                                        'UpdateUserId' => $user['StaffId'],
                                        'UpdateDateTime' => getCurentDateTime()
                                    ), $s['SSLId']);
                                    $commentLogSSL[] = 'gia hạn gói mới <strong>'.$this->genCode($deadlineId, 'KHPM').'</strong>';
                                    $this->Mactionlogs->saveLog($ssl['SSLId'], ID_LOG_SSL, ID_UPDATE, $user, $commentLogSSL);
                                }
                                if (isset($arrDeadlineDetails)) {
                                    foreach ($arrDeadlineDetails as $detail) {
                                        $ssldetails = $this->Mssldetails->getBy(array('SSLId' => $s['SSLId'], 'PackageId' => $detail['PackageId']));
                                        if (count($ssldetails) > 0) {
                                            $activeExpiryEndDate = $detail['ActiveExpiryStartDate'];
                                            if (!empty($ssldetails[0]['ActiveExpiryEndDate'])) $activeExpiryEndDate = $ssldetails[0]['ActiveExpiryEndDate'];
                                            $this->db->update('ssldetails', array(
                                                'SSLDetailStatusId' => 2,
                                                'ActiveExpiryStartDate' => empty($ssldetails[0]['ActiveExpiryStartDate']) ? $detail['ActiveExpiryStartDate'] : $ssldetails[0]['ActiveExpiryStartDate'],
                                                'ActiveExpiryEndDate' => date('Y-m-d H:i', strtotime("+" . $detail['ExpiryDate'] . " month", strtotime($activeExpiryEndDate))),
                                            ), array('SSLId' => $s['SSLId'], 'PackageId' => $detail['PackageId']));
                                            // $packageCode2 = $this->Mpackages->getFieldValue(array('PackageId' => $detail['PackageId']), 'PackageCode', '');
                                            // $logSSLDetail = array(
                                            //     'ItemTypeId' => 8,
                                            //     'CrUserId' => $user['StaffId'],
                                            //     'CrDateTime' => getCurentDateTime(),
                                            //     'ActionTypeId' => 2,
                                            //     'Comment' => $user['FullName'] . ': Vừa gia hạn thêm cho gói PM mở rộng có mã: ' . $packageCode2,
                                            //     'ItemId' => $this->Mssldetails->getFieldValue(array('SSLId' => $s['SSLId'], 'PackageId' => $detail['PackageId']), 'SSLDetailId', 0),
                                            // );
                                            // $this->Mactionlogs->save($logSSLDetail);
                                        } else {
                                            $sslActiveExpiryStartDate = strtotime('+1 days', strtotime(getCurentDateTime()));
                                            $dataSSLdetailsSave = [
                                                'SSLId' => $s['SSLId'],
                                                'PackageId' => $detail['PackageId'],
                                                'SSLDetailStatusId' => 2,
                                                'ActiveExpiryStartDate' => empty($ssldetails[0]['ActiveExpiryStartDate']) ? $detail['ActiveExpiryStartDate'] : $ssldetails[0]['ActiveExpiryStartDate'],
                                                'ActiveExpiryEndDate' => date('Y-m-d H:i:s', $sslActiveExpiryStartDate),
                                            ];
                                            $this->Mssldetails->save($dataSSLdetailsSave);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $this->Mactionlogs->saveLog($deadlineId, ID_LOG_DEADLINE, $actionTypeId, $user, $commentDeadline);
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return $deadlineId;
        }
    }

    public function genCode($sslId, $prefix = 'SSL')
    {
        return $prefix . '-' . ($sslId + 10000);
    }

    public function searchByFilter($searchText, $itemFilters, $limit, $page, $userId)
    {
        $queryCount = "select deadlines.DeadlineId AS totalRow from deadlines {joins} where {wheres}";
        $query = "select {selects} from deadlines {joins} where {wheres} ORDER BY deadlines.CrDateTime DESC LIMIT {limits}";
        $selects = [
            'deadlines.*',
            'users.FullName'
        ];
        $joins = [
            'users' => 'LEFT JOIN users on users.UserId = deadlines.UserId',
        ];
        $wheres = array('deadlines.DeadlineStatusId > 0');
        $dataBind = [];
        $whereSearch = '';
        $searchText = strtolower($searchText);
        //search theo text
        if (!empty($searchText)) {
            if (preg_match('/\d{4}-\d{2}-\d{2}/im', $searchText)) {
                $whereSearch = 'deadlines.CrDateTime like ?';
                $dataBind[] = "$searchText%";
            } else {
                $whereSearch = 'deadlines.DeadlineCode like ? or users.FullName like ? ';
                for ($i = 0; $i < 2; $i++) $dataBind[] = "%$searchText%";
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
                //$cond[0] là điều kiện ví dụ : < > = like .....   $cons[1] và $cond[2]  là gía trị điều kiện như 2017-01-02 và 2017-01-01
                switch ($filed_name) {
                    case 'status_id':
                        $wheres[] = "deadlines.DeadlineStatusId $conds[0] ?";
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
        $dataConfigTable = $this->Mconfigtables->genHtmlThTable('deadline', $userId);
        $tables = $dataConfigTable['tableTh'];

        $now = new DateTime(date('Y-m-d'));
        $datas = $this->getByQuery($query, $dataBind);
        $html = '';

        for ($i = 0; $i < count($datas); $i++) {
            $html .= '<tr id="trItem_' . $datas[$i]['DeadlineId'] . '" class="dnd-moved trItem ">';
            for ($z = 0; $z < count($tables); $z++) {
                $displayNone = '';
                if ($tables[$z]['IsActive'] == 'OFF') {
                    $displayNone = 'display:none';
                }
                $columnName = $tables[$z]['ColumnName'];
                if ($columnName == 'Check') {
                    $html .= '<td style="' . $displayNone . '" class="fix_width"><input class="checkTran iCheckTable iCheckItem" type="checkbox" value="' . $datas[$i]['DeadlineId'] . '"></td>';
                } else if (!empty($tables[$z]['Status']) && $tables[$z]['Status'] != NULL) {
                    $arrStatus = $this->Mconstants->$columnName;
                    $nameStatus = $datas[$i][$tables[$z]['Status']] > 0 ? $arrStatus[$datas[$i][$tables[$z]['Status']]] : '';
                    if ($nameStatus) {
                        $labelCss = $this->Mconstants->labelCss;
                        $html .= '<td style="' . $displayNone . '" class="text-center"><span class="' . $labelCss[$datas[$i][$tables[$z]['Status']]] . '">' . $nameStatus . '</span></td>';
                    } else {
                        $html .= '<td style="' . $displayNone . '" class="text-center"></td>';
                    }

                } else if (!empty($tables[$z]['DateTime'])) {
                    $dayDiff = getDayDiff($datas[$i][$columnName], $now);
                    $crDateTime = ddMMyyyy($datas[$i][$columnName], $dayDiff > 2 ? 'd/m/Y H:i' : 'H:i');
                    $html .= '<td style="' . $displayNone . '" >' . getDayDiffText($dayDiff) . $crDateTime . '</td>';
                } else if (!empty($tables[$z]['Edit']) && !empty($tables[$z]['IdEdit'])) {
                    $html .= '<td style="' . $displayNone . '" ><a href="' . $tables[$z]['Edit'] . '/' . $datas[$i]['DeadlineId'] . '">' . $datas[$i][$columnName] . '</a></td>';
                } else if (!empty($tables[$z]['ModelsDb']) && !empty($tables[$z]['NameRelationship'])) {
                    $models = $tables[$z]['ModelsDb'];
                    $nameRelationship = $tables[$z]['NameRelationship'];
                    $this->load->model($models);
                    if ($columnName == 'SSLId') {
                        $data = count($this->$models->getBy(array('DeadlineId' => $datas[$i]['DeadlineId'])));
                    } else {
                        $data = $this->$models->getFieldValue(array($columnName => $datas[$i][$columnName]), $nameRelationship, '');
                    }

                    $html .= '<td style="' . $displayNone . '" >' . $data . '</td>';
                } else {
                    $html .= '<td style="' . $displayNone . '" >' . $datas[$i][$columnName] . '</td>';
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
        $data['callBackTable'] = 'renderContentDeadlines';
        $data['callBackTagFilter'] = 'renderTagFilter';
        $data['totalRow'] = $totalRow;
        $data['totalIds'] = json_encode($totalIds);
        $data['totalDataShow'] = count($datas);
        return $data;
    }
}