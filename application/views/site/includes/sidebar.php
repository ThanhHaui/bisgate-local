<?php if(!empty($listAgents)){ ?>
    <div class="box-author">
        <div class="ttl-quiry"><?php echo $configSites['SIDEBAR_TITLE1']; ?></div>
        <?php foreach ($listAgents as $agent){
            $this->load->view('site/includes/agent', array('agent' => $agent));
        } ?>
    </div>
<?php } ?>
<div class="box-guide-list">
    <div class="ttl-quiry"><?php echo $configSites['SIDEBAR_TITLE2']; ?></div>
    <ul>
        <?php foreach($listMenuItems[4] as $mi){ ?>
            <li><a href="<?php echo $mi['ItemUrl']; ?>"><?php echo $mi['ItemName']; ?></a></li>
        <?php } ?>
    </ul>
</div>