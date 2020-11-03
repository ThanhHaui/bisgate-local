<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <?php if($menuId > 0){ ?>
            <section class="content-header">
                <h1><?php echo $title; ?></h1>
                <ul class="list-inline">
                    <li><button class="btn btn-primary submit">Lưu</button></li>
                    <li><a href="<?php echo base_url('menu'); ?>" class="btn btn-default">Đóng</a></li>
                </ul>
            </section>
            <section class="content">
                <div class="box box-default padding15">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông tin cơ bản</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Tên menu <span class="required">*</span></label>
                                    <input type="text" id="menuName" class="form-control" value="<?php echo $menu['MenuName']; ?>">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Vị trí</label>
                                    <?php $this->Mconstants->selectConstants('menuPositions', 'MenuPositionId', $menu['MenuPositionId']); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Trạng thái</label>
                                    <?php $this->Mconstants->selectConstants('status', 'StatusId', $menu['StatusId']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-default padding15">
                    <div class="box-header with-border">
                        <h3 class="box-title">Nội dung menu</h3>
                    </div>
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>Tiêu đề</th>
                                <th>Đường dẫn</th>
                                <th>Menu cha</th>
                                <th class="text-center">Thứ tự</th>
                                <th class="actions"></th>
                            </tr>
                            </thead>
                            <tbody id="tbodyMenuItem">
                            <?php $selectHtml = $this->Mmenuitems->getParentMenuHtml($listMenuItems);
                            foreach($listMenuItems as $mi){
                                if($mi['MenuLevel'] == 1) $class = ' class="danger"';
                                elseif($mi['MenuLevel'] == 2) $class = ' class="warning"'; ?>                                 
                                <tr id="trMenuItem_<?php echo $mi['MenuItemId']; ?>"<?php echo $class; ?>>
                                    <td class="menu-level-<?php echo $mi['MenuLevel']; ?>"><input type="text" class="form-control" id="itemName_<?php echo $mi['MenuItemId']; ?>" value="<?php echo $mi['ItemName']; ?>"/></td>
                                    <td><input type="text" class="form-control" id="itemUrl_<?php echo $mi['MenuItemId']; ?>" value="<?php echo $mi['ItemUrl']; ?>"/></td>
                                    <td><select class="form-control parent" id="parentItemId_<?php echo $mi['MenuItemId']; ?>" data-id="<?php echo $mi['MenuItemId']; ?>"><?php echo $selectHtml; ?></select></td>
                                    <td><?php $this->Mconstants->selectNumber(1, 100, 'DisplayOrder_'.$mi['MenuItemId'], $mi['DisplayOrder'], true); ?></td>
                                    <td class="actions">
                                        <a href="javascript:void(0)" class="link_update" title="Cập nhật" data-id="<?php echo $mi['MenuItemId']; ?>"><i class="fa fa-save"></i></a>
                                        <a href="javascript:void(0)" class="link_delete" title="Xóa" data-id="<?php echo $mi['MenuItemId']; ?>"><i class="fa fa-times"></i></a>
                                        <input type="text" hidden="hidden" id="parent_<?php echo $mi['MenuItemId'] ?>" value="<?php echo empty($mi['ParentItemId']) ? 0 : $mi['ParentItemId']; ?>">
                                        <input type="text" hidden="hidden" id="level_<?php echo $mi['MenuItemId'] ?>" value="<?php echo $mi['MenuLevel']; ?>">
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr id="trMenuItem_0">
                                <td class="menu-level-1"><input type="text" class="form-control" id="itemName_0" value=""/></td>
                                <td><input type="text" class="form-control" id="itemUrl_0" value=""/></td>
                                <td><select class="form-control parent" id="parentItemId_0" data-id="0"><?php echo $selectHtml; ?></select></td>
                                <td><?php $this->Mconstants->selectNumber(1, 100, 'DisplayOrder_0', 1, true); ?></td>
                                <td class="actions">
                                    <a href="javascript:void(0)" class="link_update" title="Cập nhật" data-id="0"><i class="fa fa-save"></i></a>
                                    <a href="javascript:void(0)" class="link_delete" title="Xóa" data-id="0"><i class="fa fa-times"></i></a>
                                    <input type="text" hidden="hidden" id="parent_0" value="0">
                                    <input type="text" hidden="hidden" id="level_0" value="1">
                                        <input type="text" hidden="hidden" id="updateMenuItem" value="<?php echo base_url('menu/updateItem'); ?>">
                                    <input type="text" hidden="hidden" id="deleteMenuItem" value="<?php echo base_url('menu/deleteItem'); ?>">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <ul class="list-inline pull-right margin-right-10">
                    <li><input class="btn btn-primary submit" type="submit" name="submit" value="Lưu"></li>
                    <li><a href="<?php echo base_url('menu'); ?>" id="menuListUrl" class="btn btn-default">Đóng</a></li>
                    <input type="text" hidden="hidden" id="menuId" value="<?php echo $menuId; ?>">
                    <input type="text" hidden="hidden" id="updateMenuUrl" value="<?php echo base_url('menu/update'); ?>">
                    <input type="text" hidden="hidden" id="editMenuUrl" value="<?php echo base_url('menu/edit'); ?>/">
                </ul>
            </section>
                </section>
            <?php } else{ ?>
                <section class="content"><?php $this->load->view('includes/notice'); ?></section>
            <?php } ?>
        </div>
    </div>
<?php $this->load->view('includes/footer'); ?>