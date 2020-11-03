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
                <?php echo form_open('api/config/update/2', array('id' => 'configForm')); ?>
                <div class="box box-default padding15">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label">Property Home Title</label>
                            <input type="text" class="form-control" name="PROPERTY_HOME_TITLE" value="<?php echo $listConfigs['PROPERTY_HOME_TITLE']; ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Property Home Desc</label>
                            <input type="text" class="form-control" name="PROPERTY_HOME_DESC" value="<?php echo $listConfigs['PROPERTY_HOME_DESC']; ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Agent Home Title</label>
                            <input type="text" class="form-control" name="AGENT_HOME_TITLE" value="<?php echo $listConfigs['AGENT_HOME_TITLE']; ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Agent Home Desc</label>
                            <input type="text" class="form-control" name="AGENT_HOME_DESC" value="<?php echo $listConfigs['AGENT_HOME_DESC']; ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">About Home Title</label>
                            <input type="text" class="form-control" name="ABOUT_HOME_TITLE" value="<?php echo $listConfigs['ABOUT_HOME_TITLE']; ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">About Home Video</label>
                            <input type="text" class="form-control" name="ABOUT_HOME_VIDEO" value="<?php echo $listConfigs['ABOUT_HOME_VIDEO']; ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">About Home Desc</label>
                            <textarea class="form-control" name="ABOUT_HOME_DESC"><?php echo $listConfigs['ABOUT_HOME_DESC']; ?></textarea>
                        </div>
                    </div>
                </div>
                <ul class="list-inline pull-right margin-right-10">
                    <li><input class="btn btn-primary submit" type="submit" name="submit" value="Cập nhật"></li>
                    <input type="text" hidden="hidden" id="autoLoad" value="2">
                </ul>
                <?php echo form_close(); ?>
            </section>
        </div>
    </div>
<?php $this->load->view('includes/footer'); ?>