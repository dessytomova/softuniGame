<?php
/**
 * @var \SoftUni\Core\ViewInterface $this
 * @var \SoftUni\Models\View\IslandNearEnemiesViewModel $model
 */
?>
<div class="col-lg-10">
    <div class="list-group table-of-contents">
        <p class="list-group-item active">Islands</p>
        <?php foreach ($model->getNearestIslands() as $island){ ?>
            <a href="#" class="list-group-item" >
                Name: <label  class="btn btn-default btn-xs"><?=$island->getName();?></label>
                Coordinates: <label  class="btn btn-default btn-xs">( X: <?=$island->getX();?></label>
                Y: <?=$island->getY();?> )
                Distance:<label  class="btn btn-default btn-xs"><?= $island->getDistance(); ?></label>
            </a>
        <?php } ?>
     </div>
</div>