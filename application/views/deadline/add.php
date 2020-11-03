<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><?php echo $title; ?> </h1>
            </section>
            <section class="content">
           
                <div class="box-body">
                    <div class="col-sm-8">
                        <div class="row htmlGroupExtension">
                            <div class="col-sm-12 form-group groupExtension" id="group_1" count-id="1">
                                <div class="box box-default">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Nhóm gia hạn chung 1</h3>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                            <button type="button" class="btn btn-box-tool remove_group" count-id="1"><i class="fa fa-remove"></i></button>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-2"></div>
                                                <div class="col-sm-10">
                                                    <p><a href="javascript:void(0)" class="base-package " data-id="1" count-id="1">
                                                            <input class="check-show-base" type="checkbox" value=""></a> Gói phần mềm base bắt buộc(<span id="totalBase_1">0</span>)
                                                    </p>
                                                    <div class="box-body table-responsive divTable">
                                                        <table class="table table-hover table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:60px">STT</th>
                                                                    <th>Tên gói phần mềm</th>
                                                                    <th>Giá</th>
                                                                    <th>Số tháng</th>
                                                                    <th>Thành tiền</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tbodyBase_1">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-12 form-group">
                                                <div class="col-sm-2"></div>
                                                <div class="col-sm-10">
                                                    <p><a href="javascript:void(0)" class="base-package btnShowModalBase" data-id="2" count-id="1">
                                                        <i class="fa fa-fw fa-plus-circle"></i></a> Gói phần mềm mở rộng (<span id="totalSslDetail_1">0</span>)
                                                    </p>
                                                    <div class="box-body table-responsive divTable">
                                                        <table class="table table-hover table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:60px">STT</th>
                                                                    <th>Tên gói phần mềm</th>
                                                                    <th>Giá</th>
                                                                    <th>Số tháng</th>
                                                                    <th>Thành tiền</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tbodySslDetails_1"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="custom-hr">
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-12 form-group">
                                                <div class="col-sm-2"></div>
                                                <div class="col-sm-10">
                                                    <p><a href="javascript:void(0)" class="base-package btnShowModalSSL" count-id="1">
                                                        <i class="fa fa-fw fa-plus-circle"></i></a> Danh sách thuê bao SSL (<span id="totalSsl_1">0</span>)
                                                    </p>
                                                    <div class="box-body table-responsive divTable" style="max-height: 418px;overflow: auto;">
                                                        <table class="table table-hover table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:60px">STT</th>
                                                                    <th>Mã thuê bao SSL</th>
                                                                    <th>Biển số xe</th>
                                                                    <th>Lần gia hạn gần nhất</th>
                                                                    <th>Cảnh báo</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tbodySsl_1"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <p><a href="javascript:void(0)" class="base-package btnAddGroupExtension" style="font-size:30px">
                                <i class="fa fa-fw fa-plus-circle"></i></a> Thêm nhóm gia hạn
                            </p>
                        </div>
                        
                    </div>
                    <div class="col-sm-4">
                        <div class="box box-default padding15">
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <h4><i class="fa fa-fw fa-sticky-note-o"></i>  Khách hàng</h4>
                                </div>
                                <div class="box-search-advance customer">
                                    <div class="col-sm-12 form-group">
                                        <div>
                                            <div class="possition-relative choose-customer">
                                                <input type="text" class="form-control textbox-advancesearch boxSearch"
                                                id="txtSearchCustomer" placeholder="--Chọn khách hàng--" readonly>
                                            </div>
                                            <div class="row boxInfo" style="display:none">
                                                <div class="col-sm-10">
                                                    <p class="fullName"></p>
                                                    <p>ID : <span class="userCode"></span></p>
                                                    <p>SĐT : <span class="phoneNumber"></span></p>
                                                    <p>Địa chỉ : <span class="address"></span></p>
                                                    <input type="hidden" id="userId" name="UserId" value="0">
                                                </div>
                                                <div class="col-sm-2">
                                                    <a href="javascript:void(0)" id="btnDeleteUser">x</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default" id="panelCustomer" >
                                            <div class="search-data">
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                                <input type="text" class="form-control " id="seachText" placeholder="Tìm kiếm khách hàng">
                                            </div>
                                            <div id="listUser">
                                                <input type="hidden" value="<?php echo base_url('customer/getListUser')?>" id="getListUsers">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="list-inline pull-right">
                    <li><a href="<?php echo base_url('deadline'); ?>" id="deadlineListUrl" class="btn btn-danger">Hủy</a></li>
                    <li><button class="btn btn-primary submit" type="button" data-id="1">Tạo</button></li>
                    <li><button class="btn btn-success submit" type="button" data-id="2">Tạo và duyệt</button></li>
                    <input type="hidden" id="urlGetVehicleNotInSsl" value="<?php echo base_url('ssl/getVehicleNotInSsl'); ?>">
                    <input type="hidden" id="urlGetSslInUser" value="<?php echo base_url('ssl/getSslInUser'); ?>">
                    <input type="hidden" id="urlGetPackages" value="<?php echo base_url('package/getPackages'); ?>">
                    <input type="hidden" id="deadlineId" name="DeadlineId" value="0">
                    <input type="hidden" id="itemTypeId" name="ItemTypeId" value="<?php echo $itemTypeId ?>">
                    <input type="hidden" id="urlAddMuiltDeadlines" value="<?php echo  base_url('deadline/addMuilt') ?>">
                    <input type="hidden" id="urlCheckExitUserToSsl" value="<?php echo base_url('ssl/checkExitUserToSsl') ?>">
                </ul>
            </section>
            <?php $this->load->view('deadline/_modal'); ?>
        </div>
    </div>
<?php $this->load->view('includes/footer'); ?>