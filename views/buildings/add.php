<?php
/**
 * @var \SoftUni\Core\ViewInterface $this
 * @var \SoftUni\Models\View\BuildingAddViewModel $model
 * @var \SoftUni\Models\DB\BuildingCost $bld
 */

?>
<div class="container">
    <div class="well bs-component">
        <form class="form-horizontal" method="post" action="<?=$this->url("categories", "addPost");?>">
            <fieldset>
                <legend><?= $model->getName();?></legend>
                <div class="list-group table-of-contents">
                    <ul>
                        <?php
                        foreach($model->getCostPerBuiling() as $bld){  ?>
                            <li class="list-group-item"><?= $bld->getResourceName()
                                .": ".$bld->getAmount()
                                ." for Level ".$model->getLevel();?></li>
                        <?php }?>
                    </ul>
                </div>
                <a href = "<?=$this->url("players", "profile")?>" class = ' btn btn-primary'>Cancel</a>
                <a href = "<?=$this->url("buildings", "addPost", [$model->getBuildingId(),$model->getLevel()]);?>" class = ' btn btn-warning'>Buy <?=$model->getName()?></a>
            </fieldset>
        </form>
    </div>
</div>





