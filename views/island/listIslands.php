<?php
/**
 * @var \SoftUni\Core\ViewInterface $this
 * @var \SoftUni\Models\View\IslandNearEnemiesViewModel $model
 */
?>
<div class="col-lg-10">

    <div class="list-group table-of-contents">
        <p class="list-group-item active">Islands</p>
        <?php foreach ($model->getNearestIslands() as $island){?>
            <a href="<?= $this->url("battle","start",[$model->getIslandId(), $island->getIslandId()]);?>" class="list-group-item" >
                Name: <label  class="btn btn-default btn-xs"><?=$island->getName();?></label>
                Coordinates: <label  class="btn btn-default btn-xs">( X: <?=$island->getX();?>
                Y: <?=$island->getY();?> )</label>
                Distance:<label  class="btn btn-default btn-xs"><?= $island->getDistance(); ?></label>
            </a>
        <?php } ?>
        <a href = "<?= $this->url("players","profile");?>" class = ' btn btn-primary'>Cancel</a>
     </div>
</div>