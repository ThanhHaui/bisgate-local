<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><?php echo $title; ?></h1>
                <ul class="list-inline">
                    <li><a href="<?php echo base_url('menu/add'); ?>" class="btn btn-default">Thêm mới</a></li>
                </ul>
            </section>
            <section class="content">
                <div class="box box-success">
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>Tên Menu</th>
                                <th class="text-center">Vị trí</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="actions"></th>
                            </tr>
                            </thead>
                            <tbody id="tbodyMenu">
                            <?php $labelCss = $this->Mconstants->labelCss;
                            $status = $this->Mconstants->status;
                            $menuPositions = $this->Mconstants->menuPositions;
                            foreach($listMenus as $m){ ?>
                                <tr id="trItem_<?php echo $m['MenuId']; ?>">
                                    <td><a href="<?php echo base_url('menu/edit/'.$m['MenuId']); ?>"><?php echo $m['MenuName']; ?></a></td>
                                    <td class="text-center"><span class="<?php echo $labelCss[$m['MenuPositionId']]; ?>"><?php echo $menuPositions[$m['MenuPositionId']]; ?></span></td>
                                    <td id="statusName_<?php echo $m['MenuId']; ?>" class="text-center"><span class="<?php echo $labelCss[$m['StatusId']]; ?>"><?php echo $status[$m['StatusId']]; ?></td>
                                    <td class="actions">
                                        <a href="javascript:void(0)" class="link_delete" data-id="<?php echo $m['MenuId']; ?>" title="Xóa"><i class="fa fa-trash-o"></i></a>
                                        <div class="btn-group" id="btnGroup_<?php echo $m['MenuId']; ?>">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-check"></i><span class="caret"></span> </button>
                                            <ul class="dropdown-menu">
                                                <?php foreach($status as $j => $v){ ?>
                                                    <li><a href="javascript:void(0)" class="link_status" data-id="<?php echo $m['MenuId']; ?>" data-status="<?php echo $j; ?>"><?php echo $v; ?></a></li>
                                                <?php }  ?>
                                            </ul>
                                        </div>
                                        <input type="text" hidden="hidden" id="statusId_<?php echo $m['MenuId']; ?>" value="<?php echo $m['StatusId']; ?>">
                                    </td>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </div>
                    <input type="text" hidden="hidden" id="changeStatusUrl" value="<?php echo base_url('menu/changeStatus'); ?>">
                </div>
            </section>
        </div>
    </div>
<?php $this->load->view('includes/footer'); ?>