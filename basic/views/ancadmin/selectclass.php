<ul class="lbUl product<?php echo $class?> productEvent">
    <?php
        foreach ($select as $key => $value) {
    ?>
    <li data-id="<?php echo $select[$key]['id'] ?>" data-att="<?php echo $select[$key]['short'] ?>">
        <?php echo $select[$key][$models] ?>
    </li>
    <?
        }
    ?>
</ul>