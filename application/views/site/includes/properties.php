<?php foreach ($listProperties as $p){ ?>
    <div class="col-md-6 col-lg-4 item-product">
        <?php $this->load->view('site/includes/property', array('p' => $p)); ?>
    </div>
<?php } ?>