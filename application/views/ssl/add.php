<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><?php echo $title; ?> </h1>
            </section>
            <section class="content">
            <?php echo form_open('ssl/update', array('id' => 'sslForm')); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="box box-default padding15">
                            <div class="box-search-advance customer">
                                <div class="row">
                                    <div class="col-sm-2 form-group">
                                        <p class="mt-6">Khách hàng *</p>
                                    </div>
                                    <div class="col-sm-4 form-group">
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
                                            <?php $this->load->view('includes/customer/_search_customer'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 form-group">
                                        <p class="mt-6">Xe</p>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <select class="form-control" id="vehicleId" name="VehicleId">
                                        <select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="box box-default padding15">
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <p>Cấu hình gán gói phần mềm cho thuê bao và tạo lệnh gia hạn</p>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <div class="row">
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-10">
                                            <p> <i class="fa fa-fw fa-check-square-o"></i> Gói phần mềm base bắt buộc* (<span id="totalBase">1</span>)</p>
                                            <div class="box-body table-responsive divTable">
                                                <table class="table table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:60px">STT</th>
                                                            <th>Tên gói phần mềm</th>
                                                            <th>Giá</th>
                                                            <th>Số tháng</th>
                                                            <th>Thành tiền</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyBase">
                                                       <tr data-id="<?php echo $packageBase['PackageId'] ?>" check-add="0">
                                                            <td>1</td>
                                                            <td><?php echo $packageBase['PackageName'] ?></td>
                                                            <td><input class=" cost packagePrice" value="0"> đ/tháng</td>
                                                            <td><input class="cost expiryDate" value="0"> tháng</td>
                                                            <td class="packageTotalPrice">0</td>
                                                       </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <div class="row">
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-10">
                                            <p><a href="javascript:void(0)" class="base-package btnShowModalBase" data-id="2">
                                                <i class="fa fa-fw fa-plus-circle"></i></a> Gói phần mềm mở rộng (<span id="totalSslDetail">0</span>)
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
                                                    <tbody id="tbodySslDetails"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="list-inline pull-right">
                    <li><a href="<?php echo base_url('ssl'); ?>" id="sslListUrl" class="btn btn-danger">Hủy</a></li>
                    <li><button class="btn submit submit_hide" type="submit">Tạo thuê bao SSL</button></li> <!-- submit_hide  -->
                    <input type="hidden" id="urlGetVehicleNotInSsl" value="<?php echo base_url('ssl/getVehicleNotInSsl'); ?>">
                    <input type="hidden" id="urlGetPackages" value="<?php echo base_url('package/getPackages'); ?>">
                    <input type="hidden" id="sslId" name="SSLId" value="0">
                    <input type="hidden" id="itemTypeId" name="ItemTypeId" value="<?php echo $itemTypeId ?>">
                </ul>
            <?php echo form_close(); ?>
            </section>
        </div>
    </div>
    <?php $this->load->view('ssl/_modal'); ?>
<?php $this->load->view('includes/footer'); ?>