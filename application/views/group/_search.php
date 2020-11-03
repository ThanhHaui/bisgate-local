<div class="row">
    <div class="col-sm-7">
        <div class="input-group margin">
            <div class="input-group-btn">
                <button type="button" class="btn dropdown-toggle transform" data-toggle="dropdown"
                        aria-expanded="false">
                    Chọn loại tiêu chí lọc <span class="fa fa-angle-down"></span>
                </button>
                <ul class="dropdown-menu">
                    <li class="dropdown-submenu">
                        <a class="btn-filter-data" aria-expanded="false" data-toggle="dropdown" tabindex="-1"
                           href="javascript:void(0);" value-id="0"><span>Tình trạng hợp tác</span> <span
                                    class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php foreach ($this->Mconstants->status as $k => $v) : ?>
                                <li>
                                    <div><a class="btn-filter-data" tabindex="-1" href="javascript:void(0);"
                                            text-opertor="là" value-operator="=" field-select="status_id"
                                            check-length="0" value-id="<?php echo $k; ?>"><?php echo $v; ?></a></div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
            </div>
            <input type="text" hidden="hidden" value="<?php echo base_url('group/searchByFilter/'); ?>"
                   id="btn-filter">
            <input type="text" class="form-control" id="itemSearchName" placeholder="Nhập thông tin tìm kiếm"/>
            <span class="input-group-btn" style="display: none">
			    <button id="remove-filter" data-href="<?php echo base_url('filter/delete'); ?>" type="button" disabled
                        class="btn btn-disable"><i class="fa fa-times"></i></button>
			</span>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="input-group margin">
            <ul id="btn_add_filter" class="form-control ">
                <li class="position-relative btn_add_filter_click" value="0">Danh sách báo cáo <i class="fa fa-caret-down" aria-hidden="true"></i>
                    <ul>
		                <?php foreach ($listFilters as $f) { ?>
		                    <li class="btn_add_filter_click" value="<?php echo $f['FilterId'] ?>"><?php echo $f['FilterName']; ?>  &nbsp&nbsp  <i class="fa fa-info-circle" aria-hidden="true"> <span><?php echo $f['FilterNote']; ?></span>  </i></li>
		                <?php } ?>
		            </ul>
            	</li>
            </ul>
            <span class="input-group-btn">
                <button class="btn btn-default btnShowModalListFilter" type="button">
                	<i class="fa fa-fw fa-cog"></i>
            </button>
            </span>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="input-group margin">
            <input type="text" class="form-control" disabled="true" id="txtCountColTable" value="hiển thị 0/0 cột">
            <span class="input-group-btn">
              <button type="button" class="btn btn-default btn-flat" id="btnShowModalConfigTable"><i
                          class="fa fa-fw fa-cog"></i></button>
            </span>
        </div>
    </div>
</div>

<div class="mb10 mgt-10">
    <ul id="container-filters"></ul>
</div>