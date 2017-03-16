<?php
    $class1 = array();
    foreach ($select as $key => $value) {
        $class = $select[$key]['model'];
        $short = $select[$key]['short'];
        $arr = array(
            'key' => $short,
            'val' => $class
        );
        if(!in_array($arr, $class1)){
            array_push($class1,$arr);
        }
    }
        //$class1 = json_encode($class1);
?>
<?php
    foreach($class1 as $key => $value){
?>

    <p data-att="<?php echo $value['key']?>" data-val="<?php echo $value['val']?>" class="attributeP"><?php echo $value['val']?></p>
    <ul class="lbUl productCheckbox">
        <?php
            foreach ($select as $key1 => $value1) {
                if($value['val'] == $select[$key1]['model']){
        ?>
            <li data-att="<?php echo $select[$key1]['shorts']?>" data-val="<?php echo $select[$key1]['attribute']?>">
                <?php 
                    echo $select[$key1]['attribute'];
                ?>
            </li>
        <?php
                }
            }
        ?>
    </ul>
<?
    }
?>