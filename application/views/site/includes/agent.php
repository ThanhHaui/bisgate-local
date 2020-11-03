<div class="item-agents">
    <div class="thumb">
        <img src="<?php echo USER_PATH.$agent['AgentAvatar']; ?>" alt="<?php echo $agent['AgentName']; ?>" style="width: 350px;height: 350px;">
        <div class="scl-agents">
            <a href="mailto:<?php echo $agent['Email']; ?>"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
            <a href="<?php echo $agent['GooglePlus']; ?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
            <a href="<?php echo $agent['Facebook']; ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="<?php echo $agent['Twitter'] ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
        </div>
    </div>
    <div class="info">
        <div class="name"><?php echo $agent['AgentName']; ?></div>
        <div class="position"><?php echo $agent['PositionName']; ?></div>
        <div class="phone"><a href="tel:<?php echo $agent['PhoneNumber']; ?>"><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $agent['PhoneNumber']; ?></a></div>
        <div class="mail"><a href="mailto:<?php echo $agent['Email']; ?>"><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo $agent['Email']; ?></a></div>
        <a class="wishlist" href="<?php echo $this->Mconstants->getUrl($agent['AgentSlug'], $agent['AgentId'], 2); ?>">View Agent Listings</a>
    </div>
</div>