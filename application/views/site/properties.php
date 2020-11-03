<?php $this->load->view('site/includes/header'); ?>
    <section class="sec-gray sec-filter-small">
        <?php $this->load->view('site/includes/filter'); ?>
    </section>
    <div class="block-breadcrumb sec-gray">
        <div class="container">
            <div class="box-breadcrumb">
                <ul>
                    <li><a class="trans" href="<?php echo base_url(); ?>">Home</a></li>
                    <li><a class="trans" href="<?php echo $configSites['pageUrl']; ?>">Property</a></li>
                </ul>
            </div>
        </div>
    </div>
    <section class="sec-head-page">
        <div class="container">
            <h2 class="ttl-title-page"><?php echo $pageTitle; ?></h2>
            <div class="count-item">Found:<strong> <?php echo priceFormat($propertyCount); ?> Properties</strong></div>
            <?php if($propertyCount > 0){ ?>
                <div class="block-sort dis-flex justify-content-between">
                    <div class="sort">
                        <label><strong>sort by</strong></label>
                        <div class="style-select style-white">
                            <select>
                                <option value="0">Updated time ascending</option>
                                <option value="1">Updated time descending</option>
                                <option value="2">Price (US$) ascending</option>
                                <option value="3">Price (US$) descending</option>
                                <option value="4">Bedroom ascending</option>
                                <option value="5">Bedroom descending</option>
                                <option value="6">Bathroom ascending</option>
                                <option value="7">Bathroom descending</option>
                            </select>
                        </div>
                    </div>
                    <div class="view">
                        <strong class="text">View</strong>
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