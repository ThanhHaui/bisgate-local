<option value="0">--- Trọng tải ---</option>-->
<?php $name ='';
if($listName ==1){
    $name ='Tấn';
}
if($listName ==2){
    $name ='Người';
}
?>
<?php foreach ($listValue as $item) { ?>
    <option value="<?= $item ?>"><?= $item ?> <?= $name ?></option>
<?php } ?>