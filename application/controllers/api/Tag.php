<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag extends MY_Controller{

    public function updateItem(){
        $this->checkUserLogin(true);
        $itemIds = json_decode(trim($this->input->post('ItemIds')), true);
        $tagNames = json_decode(trim($this->input->post('TagNames')), true);
        $itemTypeId = $this->input->post('ItemTypeId');
        if(!empty($itemIds) && !empty($tagNames) && $itemTypeId > 0){
            $changeTagTypeId = $this->input->post('ChangeTagTypeId'); // 1- add 2- remove 3 - update item
            $this->loadModel(['Mtags', 'Mitemtags']);
            foreach($itemIds as $itemId) {
                $this->Mitemtags->deleteMultiple(['ItemId' => $itemId, 'ItemTypeId' => $itemTypeId]);
            }
            $flag = $this->Mtags->updateItem($itemIds, $tagNames, $itemTypeId, $changeTagTypeId);
            if($flag) echo json_encode(array('code' => 1, 'message' => "Cập nhật nhãn thành công"));
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }
}