<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header no-pd-lr">
                <h1 class="ttl-list-order ft-seogeo"><?php echo $title; ?></h1>
                <ul class="list-inline new-stl">
                    <?php if($permissionAdd): ?>
                    <li><button class="btn btn-primary" id="showModalSim">Thêm</button></li>
                    <?php endif; ?>
                </ul>

            </section>
            <section class="content upn ft-seogeo">
                <div class="">
                    <?php $this->load->view('sim/_search'); ?>
                </div>
                <div class="">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-sm-3 fix-width-200">
                                <select class="form-control" id="selectAction" style="display: none;">
                                    <option value="">Chọn hành động</option>
                                </select>
                            </div>
                            <div class="col-sm-2 fix-width-200">
                                <select class="form-control" id="selectData" style="display: none;"></select>
                            </div>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding divTable">
                         <table class="table new-style table-hover table-bordered" id="table-data">
                            <thead id="html-thead">
                            </thead>
                            <tbody id="tbodySim"></tbody>
                        </table>
                    </div>
                    <div class="box-footer"></div>
                </div>
                <div class="">
                <?php $this->load->view('includes/modal/tag'); ?>
                <?php $this->load->view('includes/modal/filter'); ?>
                <input type="hidden" id="itemTypeId" value="<?php echo $itemTypeId; ?>">
                </div>
            </section>
        </div>
    </div>
    <?php if($permissionAdd): ?>
    <?php $this->load->view('sim/_modal_sim'); ?>
    <?php endif; ?>
    <?php $this->load->view('includes/modal/config_table', array('config_filter' => 'sim/_config_filter.php')); ?>
<?php $this->load->view('includes/footer'); ?>
<?php $this->load->view('includes/loading'); ?>