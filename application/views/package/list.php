<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header no-pd-lr">
                <h1 class="ttl-list-order ft-seogeo"><?php echo $title; ?></h1>
                <ul class="list-inline new-stl">
                    <li><a href="<?php echo base_url('package/add') ?>" class="btn btn-primary">Thêm</a></li>
                </ul>
            </section>
            <section class="content">
                <div class="box box-success">
                    <?php echo form_open('package/update', array('id' => 'packagesForm')); ?>
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>Mã phần mềm</th>
                                <th>Tên phần mềm</th>
                                <th>Loại gói phần mềm</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyPackages">
                            <?php
                            foreach($listPackages as $bt){ ?>
                                <tr id="package_<?php echo $bt['PackageId']; ?>">
                                    <td><a href="<?php echo current_url()?>/edit/<?php echo $bt['PackageId']?>"><?php echo $bt['PackageCode']; ?></a></td>
                                    <td id="packageName_<?php echo $bt['PackageId']; ?>"><a href="<?php echo current_url()?>/edit/<?php echo $bt['PackageId']?>"><?php echo $bt['PackageName']; ?></a></td>
                                    <td><?php echo $bt['PackageTypeId'] == 1 ? 'Gói base': ' Gói mở rộng'; ?></td>
                                    <td class="actions">
                                        <?php if($bt['PackageTypeId'] != 1): ?>
                                        <a href="javascript:void(0)" class="link_delete" data-id="<?php echo $bt['PackageId']; ?>" title="Xóa"><i class="fa fa-trash-o"></i></a>
                                        <input type="text" id="deletePackageUrl" value="<?php echo base_url('package/delete'); ?>" hidden="hidden">
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </section>
        </div>
    </div>
<?php $this->load->view('includes/footer'); ?>
<?php $this->load->view('includes/loading'); ?>