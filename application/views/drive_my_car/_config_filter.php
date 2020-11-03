<li class="dropdown-submenu">
    <a class="btn-filter-data-add btn-filter-data-lv1" aria-expanded="false" data-toggle="dropdown" tabindex="-1" href="javascript:void(0);" value-id="0"><span>Loại bằng</span> <span class="caret"></span></a>
    <ul class="dropdown-menu">
        <?php foreach($this->Mconstants->licenceTypes as $k => $v) :?>
            <li>
                <div><a class="btn-filter-data-add btn-filter-data-lv2" tabindex="-1" href="javascript:void(0);" text-opertor="là" value-operator="=" field-select="licence_type_id" check-length="0" value-id="<?php echo $k; ?>"><?php echo $v; ?></a></div>
            </li>
        <?php endforeach;?>
    </ul>
</li>