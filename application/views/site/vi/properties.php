<?php $this->load->view('site/includes/header'); ?>
    <section class="sec-gray sec-filter-small">
        <?php $this->load->view('site/includes/filter'); ?>
    </section>
    <div class="block-breadcrumb sec-gray">
        <div class="container">
            <div class="box-breadcrumb">
                <ul>
                    <li><a class="trans" href="<?php echo base_url(); ?>">Trang chủ</a></li>
                    <li><a class="trans" href="<?php echo $configSites['pageUrl']; ?>">Property</a></li>
                </ul>
            </div>
        </div>
    </div>
    <section class="sec-head-page">
        <div class="container">
            <h2 class="ttl-title-page"><?php echo $pageTitle; ?></h2>
            <div class="count-item">Tổng cộng:<strong> <?php echo priceFormat($propertyCount); ?> Properties</strong></div>
            <?php if($propertyCount > 0){ ?>
                <div class="block-sort dis-flex justify-content-between">
                    <div class="sort">
                        <label><strong>Sắp xếp theo</strong></label>
                        <div class="style-select style-white">
                            <select>
                                <option value="0">Bài mới nhất</option>
                                <option value="1">Bài cũ nhất</option>
                                <option value="2">Giá (VNĐ) tăng dần</option>
                                <option value="3">Giá (VNĐ) giảm dần</option>
                                <option value="4">Phòng ngủ tăng dần</option>
                                <option value="5">Phòng ngủ giảm dần</option>
                                <option value="6">Phòng tắm tăng dần</option>
                                <option value="7">Phòng tắm giảm dần</option>
                            </select>
                        </div>
                    </div>
                    <div class="view">
                        <strong class="text">Chế độ</strong>
                        <span class="view-gird active js-view-product" data-view="view-gird"><i class="fa fa-th-large" aria-hidden="true"></i></span>
                        <span class="view-list js-view-product" data-view="view-list"><i class="fa fa-th-list" aria-hidden="true"></i></span>
                    </div>
                </div>
                <div class="block-product-cat js-list-item view-gird">
                    <div class="row">
                        <?php $this->load->view('site/includes/properties', array('listProperties' => $listProperties)); ?>
                    </div>
                    <?php echo getPaggingHtmlFront($pageCurrent, $pageCount, $categoryUrlPage); ?>
                </div>
            <?php } ?>
        </div>
    </section>
<?php $this->load->view('site/includes/footer'); ?>