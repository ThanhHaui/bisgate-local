<div class="block-filter block-filter-desktop">
    <div class="container-fluid">
        <div class="content-filter stl-page">
            <form action="<?php echo base_url('search.html'); ?>" method="get">
                <div class="row line-filter">
                    <div class="col-md-2 col-lg-2">
                        <div class="style-select">
                            <select name="property_type">
                                <option value="0">Chuyên mục</option>
                                <?php foreach($listCateProperties as $c){ ?>
                                    <option value="<?php echo $c['CategoryId']; ?>"<?php if(isset($_GET['property_type']) && $_GET['property_type'] == $c['CategoryId']) echo ' selected="selected"'; ?>><?php echo $c['CategoryName']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php $roomNumbers = [1, 2, 3, 4]; ?>
                    <div class="col-md-2 col-lg-2">
                        <div class="style-select">
                            <select name="bedroom">
                                <option value="0">Phòng ngủ</option>
                                <?php foreach($roomNumbers as $i): ?>
                                    <option value="<?php echo $i ?>"<?php if(isset($_GET['bedroom']) && $_GET['bedroom'] == $i) echo ' selected="selected"'; ?>><?php echo $i ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-lg-2">
                        <div class="style-select">
                            <select name="bathroom">
                                <option value="0">Phòng tắm</option>
                                <?php foreach($roomNumbers as $i): ?>
                                    <option value="<?php echo $i ?>"<?php if(isset($_GET['bathroom']) && $_GET['bathroom'] == $i) echo ' selected="selected"'; ?>><?php echo $i ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 col-lg-1">
                        <input class="style-text" type="text" name="min_price" value="<?php echo isset($_GET['min_price']) ? $_GET['min_price'] : ''; ?>" placeholder="Min. Rent">
                    </div>
                    <div class="col-md-1 col-lg-1">
                        <input class="style-text" type="text" name="max_price" value="<?php echo isset($_GET['max_price']) ? $_GET['max_price'] : ''; ?>" placeholder="Max. Rent">
                    </div>
                    <div class="col-md-2 col-lg-2">
                        <input class="style-text" type="text" name="s" value="<?php echo isset($_GET['s']) ? $_GET['s'] : ''; ?>" placeholder="Tên căn hộ">
                    </div>
                    <div class="col-md-2 col-lg-2">
                        <input class="style-btn-submit" type="submit" value="Tìm kiếm">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="block-filter block-filter-mobile">
    <div class="container-fluid">
        <div class="content-filter stl-page">
            <div class="line-filter">
                <div class="pull-left">
                    <form action="<?php echo base_url('search.html'); ?>" method="get">
                        <input hidden="hidden" style="display: none;" type="text" name="s" value="<?php echo isset($_GET['s']) ? $_GET['s'] : ''; ?>">
                        <input class="style-btn-submit" type="submit" value="Tìm kiếm">
                    </form>
                </div>
                <div class="pull-right">
                    <input class="style-btn-submit btn-advanced-search" type="button" value="Tìm kiếm nâng cao">
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
