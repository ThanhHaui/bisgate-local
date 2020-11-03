<div class="box-body">
    <div class="box-search-advance customer">
        <div class="row mgbt-10">
            <div class="col-sm-3">
                <p class="mt-6">Mức tiêu hao nhiên liệu TB</p>
            </div>
            <div class="col-sm-6">
                <input type="number" class="form-control " id="FuelLevel" placeholder="" value="<?php echo $FuelLevel?>">
            </div>
            <div class="col-sm-3">
                lit/100km
            </div>
        </div>
    </div>
    
</div>
<div class="box box-default classify padding20">
    <?php 
        $this->load->view('includes/action_logs', 
                array(
                    'listActionLogs' =>  $this->Mactionlogs->getList($vehicle['VehicleId'], $itemTypeId, [ID_TAB_CONFIG_IN_VEHICLE]),
                    'itemId' => $vehicle['VehicleId'],
                    'itemTypeId' => $itemTypeId
                )
            );
    ?>
</div>
<input type="text" hidden="hidden" id="updateFuelLevelVehicle" value="<?php echo base_url('api/UserVehicle/updateFuelLevel'); ?>">
