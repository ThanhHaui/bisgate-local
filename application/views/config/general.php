<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><?php echo $title;?></h1>
                <ul class="list-inline">
                    <li><button class="btn btn-primary submit">Cập nhật</button></li>
                </ul>
            </section>
            <section class="content">
                <?php echo form_open('api/config/update/1', array('id' => 'configForm')); ?>
                <div class="box box-default padding15">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Tên công ty <span class="required">*</span></label>
                                    <input type="text" class="form-control hmdrequired" name="COMPANY_NAME" value="<?php echo $listConfigs['COMPANY_NAME']; ?>" data-field="Tên công ty">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Tên website <span class="required">*</span></label>
                                    <input type="text" class="form-control hmdrequired" name="SITE_NAME" value="<?php echo $listConfigs['SITE_NAME']; ?>" data-field="Tên website">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Điện thoại <span class="required">*</span></label>
                                    <input type="text" class="form-control hmdrequired" name="PHONE_NUMBER" value="<?php echo $listConfigs['PHONE_NUMBER']; ?>" data-field="Điện thoại">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Office Phone <span class="required">*</span></label>
                                    <input type="text" class="form-control hmdrequired" name="OFFICE_PHONE" value="<?php echo $listConfigs['OFFICE_PHONE']; ?>" data-field="Office Phone">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Email liên hệ <span class="required">*</span></label>
                                    <input type="text" class="form-control hmdrequired" name="EMAIL_CONTACT" value="<?php echo $listConfigs['EMAIL_CONTACT']; ?>" data-field="Email liên hệ">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Email khách hàng <span class="required">*</span></label>
                                    <input type="text" class="form-control hmdrequired" name="EMAIL_COMPANY" value="<?php echo $listConfigs['EMAIL_COMPANY']; ?>" data-field="Email khách hàng">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Mô tả website <span class="required">*</span></label>
                            <textarea rows="2" class="form-control hmdrequired" name="META_DESC" data-field="Mô tả website"><?php echo $listConfigs['META_DESC']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Địa chỉ <span class="required">*</span></label>
                            <input type="text" class="form-control hmdrequired" name="ADDRESS" value="<?php echo $listConfigs['ADDRESS']; ?>" data-field="Địa chỉ">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Địa chỉ Google Map</label>
                            <textarea class="form-control" name="ADDRESS_MAP" rows="2"><?php echo $listConfigs['ADDRESS_MAP']; ?></textarea>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Facebook</label>
                                    <input type="text" class="form-control" name="FACEBOOK_LINK" value="<?php echo $listConfigs['FACEBOOK_LINK']; ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Twitter</label>
                                    <input type="text" class="form-control" name="TWITTER_LINK" value="<?php echo $listConfigs['TWITTER_LINK']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Google Plus</label>
                                    <input type="text" class="form-control" name="GOOGLEPLUS_LINK" value="<?php echo $listConfigs['GOOGLEPLUS_LINK']; ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Zalo</label>
                                    <input type="text" class="form-control" name="ZALO" value="<?php echo $listConfigs['ZALO']; ?>">
                                </div>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Viber</label>
                                    <input type="text" class="form-control" name="VIBER" value="<?php echo $listConfigs['VIBER']; ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Whatsap</label>
                                    <input type="text" class="form-control" name="WHATSPAP" value="<?php echo $listConfigs['WHATSPAP']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Youtube title (đầu trang)</label>
                                    <input type="text" class="form-control" name="YOUTUBE_TITLE_HEADER" value="<?php echo $listConfigs['YOUTUBE_TITLE_HEADER']; ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Youtube Link (đầu trang)</label>
                                    <input type="text" class="form-control" name="YOUTUBE_LINK_HEADER" value="<?php echo $listConfigs['YOUTUBE_LINK_HEADER']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Youtube image (chân trang) <button type="button" class="btn btn-box-tool" id="btnUpLogo_youtube"><i class="fa fa-upload"></i> Chọn hình</button></label>
                                    <img src="<?php echo IMAGE_PATH.$listConfigs['YOUTUBE_IMAGE_FOOTER']; ?>" id="imgLogo_youtube" style="width: 50px;">
                                    <input type="text" hidden="hidden" id="logoImage_youtube" name="YOUTUBE_IMAGE_FOOTER" value="<?php echo $listConfigs['YOUTUBE_IMAGE_FOOTER']; ?>">
                                    <div class="progress" id="fileProgress2" style="display: none;">
                                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <input type="file" style="display: none;" id="inputFileImage2">
                                    <input type="text" hidden="hidden" id="uploadFileUrl2" value="<?php echo base_url('file/upload'); ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Youtube title (chân trang)</label>
                                    <input type="text" class="form-control" name="YOUTUBE_TITLE_FOOTER" value="<?php echo $listConfigs['YOUTUBE_TITLE_FOOTER']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Giới thiệu 1</label>
                                    <input type="text" class="form-control" name="INTRODUCE_TITLE_1" value="<?php echo $listConfigs['INTRODUCE_TITLE_1']; ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Nội dung giới thiệu 1</label>
                                    <input type="text" class="form-control" name="INTRODUCE_INFO_1" value="<?php echo $listConfigs['INTRODUCE_INFO_1']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Đánh giá</label>
                                    <input type="text" class="form-control" name="EVALUATE" value="<?php echo $listConfigs['EVALUATE']; ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Nội dung đánh giá</label>
                                    <input type="text" class="form-control" name="EVALUATE_INFO" value="<?php echo $listConfigs['EVALUATE_INFO']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Giới thiệu 2</label>
                                    <input type="text" class="form-control" name="INTRODUCE_TITLE_2" value="<?php echo $listConfigs['INTRODUCE_TITLE_2']; ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Nội dung giới thiệu 2</label>
                                    <input type="text" class="form-control" name="INTRODUCE_INFO_2" value="<?php echo $listConfigs['INTRODUCE_INFO_2']; ?>">
                                </div>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Giới thiệu giá</label>
                                    <input type="text" class="form-control" name="PRICE_TITLE" value="<?php echo $listConfigs['PRICE_TITLE']; ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Mô tả giá</label>
                                    <input type="text" class="form-control" name="PRICE_DESCRIPTION" value="<?php echo $listConfigs['PRICE_DESCRIPTION']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                               <div class="form-group">
                                    <label class="control-label">Review</label>
                                    <input type="text" class="form-control" name="REVIEW_TITLE" value="<?php echo $listConfigs['REVIEW_TITLE']; ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                               <div class="form-group">
                                    <label class="control-label">Review Mô tả</label>
                                    <input type="text" class="form-control" name="REVIEW_DESCRIPTION" value="<?php echo $listConfigs['REVIEW_DESCRIPTION']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Copyright <span class="required">*</span></label>
                            <input type="text" class="form-control hmdrequired" name="COPYRIGHT" value="<?php echo $listConfigs['COPYRIGHT']; ?>" data-field="Copyright">
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Google Analytics</label>
                                    <textarea class="form-control" name="GOOGLE_ANALYTICS" rows="4"><?php echo $listConfigs['GOOGLE_ANALYTICS']; ?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Facebook Pixel</label>
                                    <textarea class="form-control" name="FACEBOOK_PIXEL" rows="4"><?php echo $listConfigs['FACEBOOK_PIXEL']; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Logo đầu trang <button type="button" class="btn btn-box-tool" id="btnUpLogo"><i class="fa fa-upload"></i> Chọn hình</button></label>
                                    <img src="<?php echo IMAGE_PATH.$listConfigs['LOGO_IMAGE']; ?>" id="imgLogo" style="width: 100px;">
                                    <input type="text" hidden="hidden" id="logoImage" name="LOGO_IMAGE" value="<?php echo $listConfigs['LOGO_IMAGE']; ?>">
                                    <div class="progress" id="fileProgress1" style="display: none;">
                                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <input type="file" style="display: none;" id="inputFileImage1">
                                    <input type="text" hidden="hidden" id="uploadFileUrl" value="<?php echo base_url('file/upload'); ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Facebook Page Code</label>
                                    <textarea class="form-control" name="FACEBOOK_PAGE_CODE" rows="4"><?php echo $listConfigs['FACEBOOK_PAGE_CODE']; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="list-inline pull-right margin-right-10">
                    <li><input class="btn btn-primary submit" type="submit" name="submit" value="Cập nhật"></li>
                    <input type="text" hidden="hidden" id="autoLoad" value="1">
                </ul>
                <?php echo form_close(); ?>
            </section>
        </div>
    </div>
<?php $this->load->view('includes/footer'); ?>